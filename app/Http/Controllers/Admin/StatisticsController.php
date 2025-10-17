<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, quarter
        
        // Get enrollment statistics
        $enrollmentStats = $this->getEnrollmentStats($period);
        
        // Get revenue statistics
        $revenueStats = $this->getRevenueStats($period);
        
        // Get top courses
        $topCourses = $this->getTopCourses();
        
        // Get recent enrollments trend
        $enrollmentTrend = $this->getEnrollmentTrend($period);
        
        // Get course completion statistics
        $completionStats = $this->getCourseCompletionStats();
        
        // Get user growth
        $userGrowth = $this->getUserGrowth($period);
        
        // Format data for charts
        $enrollmentChartData = $this->formatChartData($enrollmentStats, $period);
        $revenueChartData = $this->formatRevenueChartData($revenueStats, $period);
        $userGrowthChartData = $this->formatChartData($userGrowth, $period);
        
        return view('admin.statistics.index', compact(
            'enrollmentStats',
            'revenueStats', 
            'topCourses',
            'enrollmentTrend',
            'completionStats',
            'userGrowth',
            'period',
            'enrollmentChartData',
            'revenueChartData', 
            'userGrowthChartData'
        ));
    }
    
    private function formatChartData($data, $period)
    {
        $labels = [];
        $values = [];
        
        foreach ($data as $item) {
            switch ($period) {
                case 'week':
                    $labels[] = "Tuần {$item->period}/{$item->year}";
                    break;
                case 'quarter':
                    $labels[] = "Q{$item->period}/{$item->year}";
                    break;
                default: // month
                    $labels[] = "T{$item->period}/{$item->year}";
                    break;
            }
            
            // Handle different data types
            if (isset($item->count)) {
                $values[] = $item->count;
            } elseif (isset($item->revenue)) {
                $values[] = $item->revenue;
            } else {
                $values[] = 0;
            }
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
    
    private function formatRevenueChartData($data, $period)
    {
        $labels = [];
        $values = [];
        
        foreach ($data as $item) {
            switch ($period) {
                case 'week':
                    $labels[] = "Tuần {$item->period}/{$item->year}";
                    break;
                case 'quarter':
                    $labels[] = "Q{$item->period}/{$item->year}";
                    break;
                default: // month
                    $labels[] = "T{$item->period}/{$item->year}";
                    break;
            }
            $values[] = $item->revenue ?? 0;
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
    
    private function getEnrollmentStats($period)
    {
        $query = DB::table('course_enrollments');
            
        switch ($period) {
            case 'week':
                $query->select(
                    DB::raw('WEEK(enrolled_at) as period'),
                    DB::raw('YEAR(enrolled_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('enrolled_at', '>=', Carbon::now()->subWeeks(4))
                ->groupBy(DB::raw('WEEK(enrolled_at), YEAR(enrolled_at)'));
                break;
            case 'quarter':
                $query->select(
                    DB::raw('QUARTER(enrolled_at) as period'),
                    DB::raw('YEAR(enrolled_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('enrolled_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('QUARTER(enrolled_at), YEAR(enrolled_at)'));
                break;
            default: // month
                $query->select(
                    DB::raw('MONTH(enrolled_at) as period'),
                    DB::raw('YEAR(enrolled_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('enrolled_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('YEAR(enrolled_at), MONTH(enrolled_at)'));
                break;
        }
        
        return $query->orderBy('year')->orderBy('period')->get();
    }
    
    private function getRevenueStats($period)
    {
        $query = DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id');
            
        switch ($period) {
            case 'week':
                $query->select(
                    DB::raw('WEEK(enrolled_at) as period'),
                    DB::raw('YEAR(enrolled_at) as year'),
                    DB::raw('SUM(courses.price) as revenue')
                )
                ->where('enrolled_at', '>=', Carbon::now()->subWeeks(4))
                ->groupBy(DB::raw('WEEK(enrolled_at), YEAR(enrolled_at)'));
                break;
            case 'quarter':
                $query->select(
                    DB::raw('QUARTER(enrolled_at) as period'),
                    DB::raw('YEAR(enrolled_at) as year'),
                    DB::raw('SUM(courses.price) as revenue')
                )
                ->where('enrolled_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('QUARTER(enrolled_at), YEAR(enrolled_at)'));
                break;
            default: // month
                $query->select(
                    DB::raw('MONTH(enrolled_at) as period'),
                    DB::raw('YEAR(enrolled_at) as year'),
                    DB::raw('SUM(courses.price) as revenue')
                )
                ->where('enrolled_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('YEAR(enrolled_at), MONTH(enrolled_at)'));
                break;
        }
        
        return $query->orderBy('year')->orderBy('period')->get();
    }
    
    private function getTopCourses()
    {
        return DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->join('users', 'courses.instructor_id', '=', 'users.id')
            ->select(
                'courses.id',
                'courses.title',
                'courses.price',
                'users.name as instructor_name',
                DB::raw('COUNT(course_enrollments.id) as enrollment_count'),
                DB::raw('SUM(courses.price) as total_revenue')
            )
            ->groupBy('courses.id', 'courses.title', 'courses.price', 'users.name')
            ->orderBy('enrollment_count', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function getEnrollmentTrend($period)
    {
        $days = 30;
        if ($period === 'week') $days = 7;
        if ($period === 'quarter') $days = 90;
        
        return DB::table('course_enrollments')
            ->select(
                DB::raw('DATE(enrolled_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('enrolled_at', '>=', Carbon::now()->subDays($days))
            ->groupBy(DB::raw('DATE(enrolled_at)'))
            ->orderBy('date')
            ->get();
    }
    
    private function getCourseCompletionStats()
    {
        return DB::table('courses')
            ->leftJoin('course_enrollments', 'courses.id', '=', 'course_enrollments.course_id')
            ->leftJoin('sections', 'courses.id', '=', 'sections.course_id')
            ->leftJoin('lessons', 'sections.id', '=', 'lessons.section_id')
            ->leftJoin('user_progress', function($join) {
                $join->on('lessons.id', '=', 'user_progress.lesson_id')
                     ->on('course_enrollments.user_id', '=', 'user_progress.user_id');
            })
            ->select(
                'courses.title',
                DB::raw('COUNT(DISTINCT course_enrollments.user_id) as total_enrollments'),
                DB::raw('COUNT(DISTINCT lessons.id) as total_lessons'),
                DB::raw('COUNT(DISTINCT CASE WHEN user_progress.is_completed = 1 THEN user_progress.id END) as completed_lessons'),
                DB::raw('ROUND(
                    COUNT(DISTINCT CASE WHEN user_progress.is_completed = 1 THEN user_progress.id END) * 100.0 / 
                    NULLIF(COUNT(DISTINCT lessons.id) * COUNT(DISTINCT course_enrollments.user_id), 0), 2
                ) as completion_rate')
            )
            ->groupBy('courses.id', 'courses.title')
            ->having('total_enrollments', '>', 0)
            ->orderBy('completion_rate', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function getUserGrowth($period)
    {
        $query = DB::table('users');
            
        switch ($period) {
            case 'week':
                $query->select(
                    DB::raw('WEEK(created_at) as period'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subWeeks(4))
                ->groupBy(DB::raw('WEEK(created_at), YEAR(created_at)'));
                break;
            case 'quarter':
                $query->select(
                    DB::raw('QUARTER(created_at) as period'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('QUARTER(created_at), YEAR(created_at)'));
                break;
            default: // month
                $query->select(
                    DB::raw('MONTH(created_at) as period'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'));
                break;
        }
        
        return $query->orderBy('year')->orderBy('period')->get();
    }
}
