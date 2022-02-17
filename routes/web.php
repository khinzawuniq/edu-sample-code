<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::post('login', 'Auth\LoginController@login');
Route::get('force_to_change_password/{id}', 'Auth\ResetPasswordController@forceToChangePassword');
Route::post('/student_register', 'Auth\RegisterController@studentRegister')->name('student_register');
// Route::view('my_password_reset', 'auth.passwords.reset')->name('password.reset');
Route::post('my_password/reset', 'Auth\ResetPasswordController@myPasswordReset')->name('my_password.update');
// Route::view('password_reset', 'auth.reset_password')->name('password_reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::post('request_otp', 'Auth\RegisterController@requestOtp')->name('request_otp');
Route::post('resend_otp', 'Auth\RegisterController@resendOtp')->name('resend_otp');
Route::post('store_user', 'Auth\RegisterController@storeUser')->name('store_user');

// Route::get('password/reset', 'Auth\ResetPasswordController@showPasswordRequest')->name('password.request');
Route::post('password/reset_phone', 'Auth\ResetPasswordController@PasswordRequestPhone')->name('password.request_phone');
Route::get('password/confirm_otp', 'Auth\ResetPasswordController@PasswordConfirmOtp')->name('password.confirm_otp');

Route::get('my_password/reset/{id}', 'Auth\ResetPasswordController@UserPasswordRequest');

Route::get('/check_web_device/{id}','HomeController@checkWebDevice')->name('check_web_device');

// Route::get('/', 'StartController@start')->name('start');
// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/aboutus', 'HomeController@aboutus')->name('aboutus');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/contact-mail', 'HomeController@contactMail')->name('contact-mail');
Route::get('/course_categories', 'HomeController@courseCategories')->name('course_categories');
Route::get('/courses', 'HomeController@courses')->name('courses');
Route::get('/courses/{slug}', 'HomeController@courseShow')->name('courses.show-student');

Route::get('/my_courses', 'HomeController@myCourses')->name('my_courses');
Route::get('/my_courses/show/{slug}', 'HomeController@myCourseShow')->name('my_courses.show-student');
Route::get('/my_courses/detail/{slug}', 'HomeController@myCourseDetail')->name('my_courses.detail');

Route::get('/courses/category/{slug}', 'HomeController@courseCategory')->name('courses.category');
// Route::get('/courses/category/{catid}', 'HomeController@courseCategory')->name('courses.category');
Route::get('/courses/detail/{slug}', 'HomeController@courseDetail')->name('courses.modules');
Route::get('/courses/enrol-users/{courseId}', 'HomeController@enrolUser')->name('courses.enrol-user');

Route::get('/durations_list/{course_id}/{user_id}', 'HomeController@durationsList')->name('durations_list');
Route::get('/get_learning_durations/{course_id}/{user_id}', 'HomeController@getLearningDurations')->name('get_learning_durations');
Route::get('/delete_duplicate_durations', 'HomeController@deleteDuplicateDuration')->name('delete_duplicate_durations');

Route::get('/profile/{userId}', 'HomeController@profile')->name('profile');
Route::get('/profile/edit/{userId}', 'HomeController@profileEdit')->name('profile_edit');
Route::patch('/profile/update/{userId}', 'HomeController@profileUpdate')->name('profile_update');
Route::post('/profile/update/{userId}', 'HomeController@profileUpdate')->name('profile_update');
Route::patch('/profile/update_profile_photo/{userId}', 'HomeController@profilePhotoUpdate')->name('update_profile_photo');
Route::post('/profile/update_profile_photo/{userId}', 'HomeController@profilePhotoUpdate')->name('update_profile_photo');
Route::get('/faq', 'HomeController@FAQ')->name('faq');
Route::get('/library', 'HomeController@library')->name('library');
Route::get('/save-module-order', 'HomeController@saveModuleOrder');
Route::get('/save-category-order', 'HomeController@saveCategoryOrder');
Route::get('/save-lesson-order', 'HomeController@saveLessonOrder');
Route::get('/save-course-order', 'HomeController@saveCourseOrder');

Route::get('/courses/certificate-payment/{certificate_id}', 'HomeController@certificatePayment')->name('courses.certificate-payment');
Route::get('/courses/paid_lists/{certificate_id}', 'HomeController@paidList')->name('courses.paid_lists');
Route::get('/courses/unpaid_lists/{certificate_id}', 'HomeController@unpaidList')->name('courses.unpaid_lists');
Route::get('/courses/do-paid-students/{course_id}', 'HomeController@doPaid')->name('courses.do_paid');
Route::get('/courses/do-unpaid-students/{course_id}', 'HomeController@doUnPaid')->name('courses.do_unpaid');

// course moudules & lessons
Route::get('modules-by-category/{id}', 'HomeController@getModulesByCategory')->name('courses.detail');

// calculate end date time 
Route::get('get-end-date','HomeController@getEndDate');

Route::get('exams/question_list/{exam_id}', 'Admin\QuestionController@questionList');
Route::get('exams/from_question_list/{exam_id}', 'Admin\QuestionController@fromQuestionList');
Route::post('exams/get_question_list', 'Admin\QuestionController@getDataQuestionList');
Route::post('exams/change_question_group/{groupId}', 'Admin\QuestionController@changeQuestionGroup');
Route::post('exams/question_delete/{id}', 'Admin\QuestionController@deleteQuestion');
Route::get('exams/get_questions/{exam_id}', 'Admin\QuestionController@getQuestions');
Route::get('exams/get_question_group_name', 'Admin\QuestionController@getQuestionGroupName');
// Route::get('exams/{exam_id}', 'Admin\ExamController@show');
// Route::get('exams/start_exam/{exam_id}', 'Admin\QuestionController@startExam')->name('start_exam');
Route::get('exams/unnormal_stop/{exam_id}', 'Admin\QuestionController@unNormalStopExam')->name('unnormal_stop');
// Route::get('exam_result', 'Admin\QuestionController@examResult');
Route::get('exam_result/download/{student_exam_id}', 'Admin\QuestionController@downloadExamResult');
Route::get('stop_exam', 'Admin\QuestionController@stopExam');
Route::get('student_answer', 'Admin\StudentAnswerController@studentAnswer');

Route::resource('question_group_names', 'Admin\QuestionGroupNameController');
Route::post('question_group_names/store-group', 'Admin\QuestionGroupNameController@storeGroup');
Route::get('question_group_names/{id}/select-group', 'Admin\QuestionGroupNameController@selectGroup')->name('question_group_names.select-group');
Route::get('question_group_names/{id}/save-questions', 'Admin\QuestionGroupNameController@saveQuestions')->name('question_group_names.save-questions');

Route::resource('notes','Admin\NoteController');

Route::get('payments', 'BankAccountController@index')->name('frontend.payments');
Route::post('payments', 'BankAccountController@store')->name('frontend.payments.store');
Route::get('payments/edit/{id}', 'BankAccountController@edit')->name('frontend.payments.edit');
Route::post('payments/update', 'BankAccountController@update')->name('frontend.payments.update');
Route::post('payments/delete', 'BankAccountController@destroy')->name('frontend.payments.destroy');

Route::post('payments/upload', 'BankAccountController@paymentUpload')->name('frontend.payments.payment_upload');

Route::resource('payment_descriptions', 'PaymentDescriptionController');
Route::get('payment_descriptions/edit/{id}', 'PaymentDescriptionController@edit')->name('payment_descriptions.edit');
Route::post('payment_descriptions/update', 'PaymentDescriptionController@update')->name('payment_descriptions.update');
Route::post('payment_descriptions/delete', 'PaymentDescriptionController@destroy')->name('payment_descriptions.destroy');

Route::get('/courses/download_certificate/{course_id}/{lesson_id}', 'HomeController@downloadCertificate')->name('courses.download_certificate');
Route::get('/courses/download_landscape_certificate/{course_id}', 'HomeController@downloadLandscapeCertificate')->name('courses.download_landscape_certificate');
Route::get('/courses/download_portrait_certificate/{course_id}', 'HomeController@downloadPortraitCertificate')->name('courses.download_portrait_certificate');

Route::post('/start_lesson', 'HomeController@startLesson')->name('start_lesson');
Route::post('/pause_lesson', 'HomeController@pauseLesson')->name('pause_lesson');

Route::post('/save-video-duration', 'HomeController@saveVideoDuration')->name('save_video_duration');

Route::get('/blogs', 'HomeController@knowledgeBlogs')->name('blogs');
Route::get('/blogs/{slug}', 'HomeController@blogDetail')->name('blogs.show');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard.index');
    
    Route::get('export/users','Admin\ExportController@exportUsers')->name('export.users');
    Route::get('export/coursecategory','Admin\ExportController@exportCourseCategory')->name('export.coursecategory');
    Route::get('export/courses','Admin\ExportController@exportCourses')->name('export.courses');
    Route::get('export/coursemodule','Admin\ExportController@exportCourseModule')->name('export.coursemodule');
    Route::get('export/lessons','Admin\ExportController@exportLessons')->name('export.lessons');
    Route::get('export/slideshow','Admin\ExportController@exportSlideShow')->name('export.slideshow');
    Route::get('export/questiongroup','Admin\ExportController@exportQuestionGroup')->name('export.questiongroup');
    Route::get('export/questions','Admin\ExportController@exportQuestions')->name('export.questions');
    Route::get('export/questionanswer','Admin\ExportController@exportQuestionAnswer')->name('export.questionanswer');
    Route::get('export/questionperpage','Admin\ExportController@exportQuestionPerPage')->name('export.questionperpage');
    Route::get('export/exams','Admin\ExportController@exportExams')->name('export.exams');
    Route::get('export/enroluser','Admin\ExportController@exportEnrolUser')->name('export.enroluser');
    Route::get('export/assignquestion','Admin\ExportController@exportAssignQuestion')->name('export.assignquestion');
    Route::get('export/batchgroup','Admin\ExportController@exportBatchGroup')->name('export.batchgroup');
    Route::get('export/batchgroupmodule','Admin\ExportController@exportBatchGroupModule')->name('export.batchgroupmodule');
    Route::get('export/bankaccount','Admin\ExportController@exportBankAccount')->name('export.bankaccount');
    Route::get('export/grading','Admin\ExportController@exportGrading')->name('export.grading');
    Route::get('export/loginactivity','Admin\ExportController@exportLoginActivity')->name('export.loginactivity');

    Route::resource('users','Admin\UserController');
    Route::get('users/profile/{id}','Admin\UserController@profile')->name('users.profile');
    Route::get('users/active/{id}','Admin\UserController@active')->name('users.active');
    Route::get('users/inactive/{id}','Admin\UserController@inactive')->name('users.inactive');
    Route::post('users/import','Admin\UserController@import')->name('users.import');
    Route::get('users/export/data','Admin\UserController@export')->name('users.export');
    Route::get('switch-role/{userId}','Admin\UserController@switchRole')->name('switch_role');

    Route::get('users/get_all_column/{id}','Admin\UserController@getAllColumn')->name('users.get_all_column');

    Route::get('users/reset_web_device/{id}','Admin\UserController@resetWebDevice')->name('users.reset_web_device');
    Route::get('users/courses/{id}','Admin\UserController@userCourses')->name('users.courses');

    Route::get('get_township', 'Admin\UserController@getTownship')->name('get_township');

    Route::resource('roles','Admin\RoleController');

    Route::resource('/permissions', 'Admin\PermissionController');

    // course and category management
    Route::get('category-course-management','Admin\CourseCategoryController@index');
    Route::resource('course_categories','Admin\CourseCategoryController');
    Route::resource('courses','Admin\CourseController');
    Route::post('courses/import','Admin\CourseController@import')->name('courses.import');
    Route::get('courses/export/data','Admin\CourseController@export')->name('courses.export');
    Route::get('courses/copy/{id}','Admin\CourseController@copy')->name('courses.copy');
    Route::post('courses/copy/save','Admin\CourseController@copySave')->name('courses.copy_save');
    // change category/course active-inactive status 
    Route::get('category-active/{id}','Admin\CourseCategoryController@changeStatus');
    Route::get('course-active/{id}','Admin\CourseController@changeStatus');

    // modules & lessons
    Route::resource('course_modules','Admin\CourseModuleController');
    Route::resource('lessons','Admin\LessonController');
    Route::get('lesson-order-update','Admin\LessonController@lessonOrderUpdate');
    Route::get('download-lesson/{id}','Admin\LessonController@downloadLesson');

    // change module/lesson active-inactive status 
    Route::get('module-active/{id}','Admin\CourseModuleController@changeStatus');
    Route::get('lesson-active/{id}','Admin\LessonController@changeStatus');
    Route::get('exam-active/{id}','Admin\ExamController@changeStatus');
    
    // move course & category
    Route::post('move-categories','Admin\CourseCategoryController@moveCategory');
    Route::post('move-courses','Admin\CourseController@moveCourse');

    // add lesson by type 
    Route::get('add-resource-by-type','Admin\LessonController@addLessonByType');

    // grade assingment 
    Route::post('grade-assingment','Admin\LessonController@gradeAssignment');

    // get assingnment list by lesson id 
    Route::get('assignment-list','Admin\LessonController@assignmentList');

    Route::resource('enrol-user', 'Admin\EnrolUserController');
    Route::get('get-enrol-user', 'Admin\EnrolUserController@getEnrol')->name('enrol-user.get-enrol');
    Route::patch('enrol-user-update', 'Admin\EnrolUserController@enrolUpdate')->name('enrol-user.enrol-update');
    Route::get('unenrol-user/{enrolId}', 'Admin\EnrolUserController@unEnrolUser')->name('enrol-user.unenrol');
    Route::get('enrol-user/active/{id}','Admin\EnrolUserController@active')->name('enrol-user.active');
    Route::get('enrol-user/inactive/{id}','Admin\EnrolUserController@inactive')->name('enrol-user.inactive');
    Route::get('enrol-user/serial/{course_id}','Admin\EnrolUserController@updateSerialNo')->name('enrol-user.serial');
    Route::post('enrol-user/batch_group','Admin\EnrolUserController@assignBatchGroup')->name('enrol-user.batch_group');
    Route::post('enrol-user/update_batch_group','Admin\EnrolUserController@updateBatchGroup')->name('enrol-user.update_batch_group');
    Route::get('enrol-user/apply_group/{course_id}', 'Admin\EnrolUserController@applyGroup')->name('enrol-user.apply_group');
    Route::get('enrol-user/filter_batch_group/{course_id}', 'Admin\EnrolUserController@filterGroup')->name('enrol-user.filter_batch_group');

    Route::resource('exams', 'Admin\ExamController');
    Route::resource('questions', 'Admin\QuestionController');
    
    Route::get('get-grading', 'Admin\GradingController@getGrading');
    Route::get('gradings', 'Admin\GradingController@index')->name('gradings.index');
    Route::get('gradings/create', 'Admin\GradingController@create')->name('gradings.create');
    Route::post('gradings', 'Admin\GradingController@store')->name('gradings.store');
    Route::get('gradings/edit/{ref_no}', 'Admin\GradingController@edit')->name('gradings.edit');
    Route::post('gradings/update/{ref_no}', 'Admin\GradingController@update')->name('gradings.update');
    Route::post('gradings/delete/{ref_no}', 'Admin\GradingController@destroy')->name('gradings.destroy');
    Route::get('grading-active/{ref_no}', 'Admin\GradingController@statusChange');

    Route::resource('question-per-pages', 'Admin\QuestionPerPageController');
    Route::get('question-per-page-active/{id}', 'Admin\QuestionPerPageController@statusChange');

    // Route::resource('question-groups', 'Admin\QuestionGroupController');
    // Route::get('question-groups/{id}/active', 'Admin\QuestionGroupController@active')->name('question-groups.active');
    
    // Route::resource('backend-questions', 'Admin\BackendQuestionController');
    // Route::get('backend-questions/{id}/active', 'Admin\BackendQuestionController@active')->name('backend-questions.active');

    Route::resource('slideshows', 'Admin\SlideShowController');
    Route::get('slideshows-active', 'Admin\SlideShowController@active')->name('slideshows.active');

    Route::resource('payments', 'Admin\StudentPaymentController');
    Route::get('payments/{id}/approve', 'Admin\StudentPaymentController@approve')->name('payments.approve');

    Route::get('certificate_templates', 'Admin\CertificateTemplateController@index')->name('certificate_templates.index');
    Route::get('certificate_templates/landscape', 'Admin\CertificateTemplateController@landscape')->name('certificate_templates.landscape');
    Route::get('certificate_templates/portrait', 'Admin\CertificateTemplateController@portrait')->name('certificate_templates.portrait');
    Route::post('certificate_templates', 'Admin\CertificateTemplateController@store')->name('certificate_templates.store');
    Route::patch('certificate_templates/{id}', 'Admin\CertificateTemplateController@update')->name('certificate_templates.update');
    
    Route::get('batch_groups/{course_id}', 'Admin\BatchGroupController@index')->name('batch_groups.index');
    Route::get('batch_groups/create/{course_id}', 'Admin\BatchGroupController@create')->name('batch_groups.create');
    Route::post('batch_groups', 'Admin\BatchGroupController@store')->name('batch_groups.store');
    Route::get('batch_groups/edit/{id}/{course_id}', 'Admin\BatchGroupController@edit')->name('batch_groups.edit');
    Route::post('batch_groups/update', 'Admin\BatchGroupController@update')->name('batch_groups.update');
    Route::post('batch_groups/delete/{id}', 'Admin\BatchGroupController@destroy')->name('batch_groups.destroy');

    Route::resource('faqs', 'Admin\FAQController');
    Route::get('faqs/get/{id}', 'Admin\FAQController@getFAQ');
    Route::post('faqs/update_faq', 'Admin\FAQController@updateFAQ');
    Route::get('faqs/delete_faq/{id}', 'Admin\FAQController@deleteFAQ');

    Route::resource('settings', 'Admin\SettingController');

    Route::resource('campus_address', 'Admin\CampusAddressController');
    Route::get('campus_address/active/{id}','Admin\CampusAddressController@active')->name('campus_address.active');
    Route::get('campus_address/inactive/{id}','Admin\CampusAddressController@inactive')->name('campus_address.inactive');

    Route::resource('knowledge-blogs', 'Admin\KnowledgeBlogController');
    Route::get('knowledge-blogs/active/{id}','Admin\KnowledgeBlogController@active')->name('knowledge-blogs.active');
    Route::get('knowledge-blogs/inactive/{id}','Admin\KnowledgeBlogController@inactive')->name('knowledge-blogs.inactive');

    Route::resource('blog-categories', 'Admin\BlogCategoryController');
    Route::get('blog-categories/active/{id}','Admin\BlogCategoryController@active')->name('blog-categories.active');
    Route::get('blog-categories/inactive/{id}','Admin\BlogCategoryController@inactive')->name('blog-categories.inactive');

    Route::resource('ads', 'Admin\BlogAdController');
});
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::group(['middleware' => ['web', 'auth']], function () {
       Route::post('upload-assignment','HomeController@uploadAssignment');
    });

    // mobile api 
    // For API
    Route::group(['prefix' => 'mobile'], function() { 
        Route::post('request-verification-code','MobileApiController@requestVerifyCode');
        Route::post('verify-code','MobileApiController@verifyCode');
        Route::get('login','MobileApiController@mobileLogin');
        Route::post('reset-password','MobileApiController@resetPassword');
        Route::get('request-otp','MobileApiController@requestOtp');
        Route::get('check-otp','MobileApiController@checkOtp');
        Route::get('register','MobileApiController@mobileRegister');
        Route::get('change-password','MobileApiController@changePassword');

        Route::post('enroll-course','MobileApiController@enrollCourse');

        Route::post('update-user-data','MobileApiController@updateUserData');
        Route::get('get-categories','MobileApiController@getCategories');
        Route::get('get-homepage-data','MobileApiController@getHomePageData');
        Route::get('get-courses','MobileApiController@getCourses');
        Route::get('get-courses-by-category','MobileApiController@getCoursesByCategory');
        Route::get('get-modules','MobileApiController@getModules');
        Route::get('get-lessons','MobileApiController@getLessonsByModuleId');

        Route::get('get-payments','MobileApiController@getPayments');
        Route::get('get-blogs','MobileApiController@getBlogs');
        Route::get('get-blogs-by-id','MobileApiController@getBlogsById');

        Route::post('sync-learning-time','MobileApiController@syncLearningTime');

    });

    Route::group(['middleware' => 'prevent-back-history'],function(){
        Auth::routes();
        
        // Route::get('/', 'StartController@start')->name('start');
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('exams/{exam_id}', 'Admin\ExamController@show');
        Route::get('exams/start_exam/{exam_id}', 'Admin\QuestionController@startExam')->name('start_exam');
        Route::get('exam_result/{exam_id}', 'Admin\QuestionController@examResult');
    });
    Route::get('/register', 'Auth\RegisterController@showRegister');
    Route::get('/backup', 'HomeController@backup')->name('backup');