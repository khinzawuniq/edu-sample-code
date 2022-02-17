<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use App\Exports\AllUsersExport;
use App\Exports\AllCourseCategoryExport;
use App\Exports\AllCourseExport;
use App\Exports\AllCourseModuleExport;
use App\Exports\AllLessonExport;
use App\Exports\AllSlideShowExport;

use App\Exports\AllQuestionGroupNameExport;
use App\Exports\AllQuestionExport;
use App\Exports\AllQuestionAnswerExport;
use App\Exports\AllQuestionPerPageExport;
use App\Exports\AllExamExport;
use App\Exports\AllEnrolUserExport;
use App\Exports\AllAssignQuestionExport;
use App\Exports\AllBatchGroupExport;
use App\Exports\BatchGroupModuleExport;
use App\Exports\BankAccountExport;
use App\Exports\GradingExport;
use App\Exports\LoginActivityExport;

class ExportController extends Controller
{
    public function exportUsers()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllUsersExport, 'all_user.xlsx');
    }

    public function exportCourseCategory()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllCourseCategoryExport, 'all_coursecateory.xlsx');
    }

    public function exportCourses()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllCourseExport, 'all_course.xlsx');
    }
    
    public function exportCourseModule()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllCourseModuleExport, 'all_coursemodule.xlsx');
    }
    
    public function exportLessons()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllLessonExport, 'all_lessons.xlsx');
    }
    
    public function exportSlideShow()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllSlideShowExport, 'all_slideshow.xlsx');
    }
    
    public function exportQuestionGroup()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllQuestionGroupNameExport, 'all_questiongroup.xlsx');
    }
    
    public function exportQuestions()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllQuestionExport, 'all_question.xlsx');
    }
    
    public function exportQuestionAnswer()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllQuestionAnswerExport, 'all_questionanswer.xlsx');
    }
    
    public function exportQuestionPerPage()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllQuestionPerPageExport, 'all_questionperpage.xlsx');
    }
    
    public function exportExams()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllExamExport, 'all_exam.xlsx');
    }
    
    public function exportEnrolUser()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllEnrolUserExport, 'all_enroluser.xlsx');
    }
    
    public function exportAssignQuestion()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllAssignQuestionExport, 'all_assignquestion.xlsx');
    }
    
    public function exportBatchGroup()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new AllBatchGroupExport, 'all_batchgroup.xlsx');
    }
    
    public function exportBatchGroupModule()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new BatchGroupModuleExport, 'all_batchgroupmodule.xlsx');
    }
    
    public function exportBankAccount()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new BankAccountExport, 'all_bankaccount.xlsx');
    }
    
    public function exportGrading()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new GradingExport, 'all_grading.xlsx');
    }
    
    public function exportLoginActivity()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new LoginActivityExport, 'all_loginactivity.xlsx');
    }
}
