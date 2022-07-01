<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\User;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ClaveUnicaController;

use App\Http\Controllers\TestController;

use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\DigitalSignatureController;
use App\Http\Controllers\AssigmentController;
use App\Http\Controllers\WebserviceController;

use App\Http\Controllers\VaccinationController;

use App\Http\Controllers\Agreements\StageController;
use App\Http\Controllers\Agreements\SignerController;
use App\Http\Controllers\Agreements\ProgramController;
use App\Http\Controllers\Agreements\AddendumController;
use App\Http\Controllers\Agreements\WordTestController;
use App\Http\Controllers\Agreements\AgreementController;
use App\Http\Controllers\Agreements\AccountabilityController;
use App\Http\Controllers\Agreements\WordMandateAgreeController;
use App\Http\Controllers\Agreements\ProgramResolutionController;
use App\Http\Controllers\Agreements\WordMandatePFCAgreeController;
use App\Http\Controllers\Agreements\WordWithdrawalAgreeController;
use App\Http\Controllers\Agreements\AccountabilityDetailController;
use App\Http\Controllers\Agreements\WordCollaborationAgreeController;

use App\Http\Controllers\Drugs\CourtController;
use App\Http\Controllers\Drugs\ReceptionController;
use App\Http\Controllers\Drugs\SubstanceController;
use App\Http\Controllers\Drugs\RosterAnalisisToAdminController;

use App\Http\Controllers\Unspsc\ClassController;
use App\Http\Controllers\Unspsc\FamilyController;
use App\Http\Controllers\Unspsc\ProductController;
use App\Http\Controllers\Unspsc\SegmentController;

/** Un modelo? */
use App\Pharmacies\Purchase;
use App\Http\Controllers\Pharmacies\PharmacyController;
use App\Http\Controllers\Pharmacies\PurchaseController;

use App\Http\Controllers\Rrhh\RoleController;
use App\Http\Controllers\Rrhh\UserController;
use App\Http\Controllers\Rrhh\AuthorityController;
use App\Http\Controllers\Rrhh\AttendanceController;
use App\Http\Controllers\Rrhh\OrganizationalUnitController;

use App\Http\Controllers\Suitability\TestsController;

use App\Http\Controllers\Documents\ParteController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Documents\SignatureController;
use App\Http\Controllers\Documents\ParteFileController;

use App\Http\Controllers\Resources\WingleController;
use App\Http\Controllers\Resources\MobileController;
use App\Http\Controllers\Resources\PrinterController;
use App\Http\Controllers\Resources\ComputerController;
use App\Http\Controllers\Resources\TelephoneController;

use App\Http\Controllers\Parameters\LogController;
use App\Http\Controllers\Parameters\PhraseOfTheDayController;
use App\Http\Controllers\Parameters\PurchaseMechanismController;
use App\Http\Controllers\Parameters\UnitOfMeasurementController;
use App\Http\Controllers\Parameters\PlaceController;
use App\Http\Controllers\Parameters\CommuneController;
use App\Http\Controllers\Parameters\LocationController;
use App\Http\Controllers\Parameters\ParameterController;
use App\Http\Controllers\Parameters\BudgetItemController;
use App\Http\Controllers\Parameters\PermissionController;
use App\Http\Controllers\Parameters\ProfessionController;
use App\Http\Controllers\Parameters\PurchaseTypeController;
use App\Http\Controllers\Parameters\PurchaseUnitController;
use App\Http\Controllers\Parameters\EstablishmentController;

use App\Http\Controllers\Suitability\OptionsController;
use App\Http\Controllers\Suitability\ResultsController;
use App\Http\Controllers\Suitability\SchoolsController;
use App\Http\Controllers\Suitability\SuitabilityController;
use App\Http\Controllers\Suitability\QuestionsController;
use App\Http\Controllers\Suitability\CategoriesController;
use App\Http\Controllers\Suitability\SchoolUserController;

use App\Http\Controllers\HealthPlan\HealthPlanController;

use App\Http\Controllers\Indicators\ApsController;
use App\Http\Controllers\Indicators\IaapsController;
use App\Http\Controllers\Indicators\ComgesController;
use App\Http\Controllers\Indicators\HealthGoalController;
use App\Http\Controllers\Indicators\ProgramApsController;
use App\Http\Controllers\Indicators\SingleParameterController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\QualityAps\QualityApsController;

use App\Http\Controllers\Mammography\MammographyController;
use App\Http\Controllers\Parameters\ProgramController as ParametersProgramController;
use App\Http\Controllers\Requirements\EventController;
use App\Http\Controllers\Requirements\CategoryController;
use App\Http\Controllers\Requirements\RequirementController;

use App\Http\Controllers\ServiceRequests\ValueController;
use App\Http\Controllers\ServiceRequests\ReportController;
use App\Http\Controllers\ServiceRequests\InvoiceController;
use App\Http\Controllers\ServiceRequests\AttachmentController;
use App\Http\Controllers\ServiceRequests\FulfillmentController;
use App\Http\Controllers\ServiceRequests\SignatureFlowController;
use App\Http\Controllers\ServiceRequests\ServiceRequestController;
use App\Http\Controllers\ServiceRequests\FulfillmentItemController;
use App\Http\Controllers\ServiceRequests\Denomination1121Controller;
use App\Http\Controllers\ServiceRequests\DenominationFormulaController;

use App\Http\Controllers\Programmings\ActionTypeController;
use App\Http\Controllers\Programmings\ReviewItemController;
use App\Http\Controllers\Programmings\CommuneFileController;
use App\Http\Controllers\Programmings\ProgrammingController;
use App\Http\Controllers\Programmings\ProfessionalController;
use App\Http\Controllers\Programmings\TrainingsItemController;
use App\Http\Controllers\Programmings\ActivitiesItemController;
use App\Http\Controllers\Programmings\ProgrammingDayController;
use App\Http\Controllers\Programmings\ProgrammingItemController;
use App\Http\Controllers\Programmings\ProfessionalHourController;
use App\Http\Controllers\Programmings\ActivitiesProgramController;
use App\Http\Controllers\Programmings\ProgrammingReportController;
use App\Http\Controllers\Programmings\ProgrammingReviewController;
use App\Http\Controllers\Programmings\MinisterialProgramController;
use App\Http\Controllers\Programmings\ProgrammingActivityItemController;

use App\Http\Controllers\ReplacementStaff\ProfileController;
use App\Http\Controllers\ReplacementStaff\LanguageController;
use App\Http\Controllers\ReplacementStaff\TrainingController;
use App\Http\Controllers\ReplacementStaff\ApplicantController;
use App\Http\Controllers\ReplacementStaff\CommissionController;
use App\Http\Controllers\ReplacementStaff\ExperienceController;
use App\Http\Controllers\ReplacementStaff\RequestSignController;
use App\Http\Controllers\ReplacementStaff\StaffManageController;
use App\Http\Controllers\ReplacementStaff\ContactRecordController;
use App\Http\Controllers\ReplacementStaff\ReplacementStaffController;
use App\Http\Controllers\ReplacementStaff\TechnicalEvaluationController;
use App\Http\Controllers\ReplacementStaff\Manage\ProfileManageController;
use App\Http\Controllers\ReplacementStaff\Manage\ProfessionManageController;
use App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController;
use App\Http\Controllers\ReplacementStaff\TechnicalEvaluationFileController;
use App\Http\Controllers\ReplacementStaff\Manage\LegalQualityManageController;
use App\Http\Controllers\ReplacementStaff\Manage\RstFundamentManageController;

//use App\Http\Controllers\RequestForms\SupplyPurchaseController;
use App\Models\WebService\MercadoPublico;
use App\Http\Controllers\RequestForms\PassengerController;
use App\Http\Controllers\RequestForms\PettyCashController;
use App\Http\Controllers\RequestForms\RequestFormController;
use App\Http\Controllers\RequestForms\AttachedFilesController;

use App\Http\Controllers\RequestForms\FundToBeSettledController;
use App\Http\Controllers\RequestForms\ItemRequestFormController;
use App\Http\Controllers\RequestForms\RequestFormCodeController;
use App\Http\Controllers\RequestForms\RequestFormFileController;
use App\Http\Controllers\RequestForms\RequestFormEventController;
use App\Http\Controllers\RequestForms\PurchasingProcessController;
use App\Http\Controllers\RequestForms\RequestFormMessageController;
use App\Http\Controllers\RequestForms\EventRequestFormFileController;
use App\Http\Controllers\RequestForms\InternalPurchaseOrderController;

use App\Http\Controllers\Warehouse\CategoryController as WarehouseCategoryController;
use App\Http\Controllers\Warehouse\ControlController;
use App\Http\Controllers\Warehouse\DestinationController;
use App\Http\Controllers\Warehouse\OriginController;
use App\Http\Controllers\Warehouse\ProductController as WarehouseProductController;
use App\Http\Controllers\Warehouse\StoreController;

use App\Http\Livewire\Parameters\Parameter\ParameterCreate;
use App\Http\Livewire\Parameters\Parameter\ParameterEdit;
use App\Http\Livewire\Parameters\Parameter\ParameterIndex;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/* Rutas para test Test */
Route::prefix('test')->group(function () {
    /* Maqueteo calendario */
    Route::get('/calendar', function () {
        return view('calendar');
    });
});

Route::get('/claveunica', [ClaveUnicaController::class,'autenticar'])->name('claveunica.autenticar');
Route::get('/claveunica/callback', [ClaveUnicaController::class,'callback'])->name('claveunica.callback');
Route::get('/claveunica/callback-testing', [ClaveUnicaController::class,'callback']);
Route::get('/claveunica/login/{access_token}', [ClaveUnicaController::class,'login'])->name('claveunica.login');
Route::get('/claveunica/login-external/{access_token}', [ClaveUnicaController::class,'loginExternal']);

Route::get('logout', [LoginController::class,'logout'])->name('logout');
/* Para testing, no he probado pero me la pedian en clave única */
Route::get('logout-testing', [LoginController::class,'logout'])->name('logout-testing');

Route::get('/home', [HomeController::class,'index'])->name('home');




Route::get('corrige_firmas',[ServiceRequestController::class,'corrige_firmas'])->middleware('auth');

Route::get('/open-notification/{notification}',[UserController::class,'openNotification'])->middleware('auth')->name('openNotification');

Route::prefix('webservices')->name('webservices.')->group(function () {
    Route::get('fonasa', [WebserviceController::class,'fonasa'])->middleware('auth')->name('fonasa');
});

Auth::routes(['register' => false, 'logout' => false, 'reset' => false]);

Route::get('/login/external', [LoginController::class,'showExternalLoginForm']);
Route::post('/login/external', [LoginController::class,'externalLogin']);

Route::group(['middleware' => 'auth:external'], function () {
    Route::view('/external', 'external')->name('external');
    //Route::view('/external', 'external')->name('external');
    Route::prefix('idoneidad')->as('idoneidad.')->group(function(){
    Route::get('/manual-usuario', [SuitabilityController::class, 'downloadManualUser'])->name('downloadManualUser');
    Route::get('/manual-administrador', [SuitabilityController::class, 'downloadManualAdministrator'])->name('downloadManualAdministrator');
    Route::get('/create/{school}', [SuitabilityController::class, 'createExternal'])->name('createExternal');
    Route::post('/', [SuitabilityController::class, 'storeSuitabilityExternal'])->name('storeSuitabilityExternal');
    Route::get('/list/{school}', [SuitabilityController::class, 'listOwn'])->name('listOwn');
    Route::patch('/update/{psi_request_id?}', [TestsController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/test/{psi_request_id?}', [TestsController::class, 'index'])->name('test');
    Route::post('/test', [TestsController::class, 'storeExternal'])->name('storeExternal');
    Route::get('/signed-suitability-certificate-pdf/{id}', [SuitabilityController::class, 'signedSuitabilityCertificatePDF'])->name('signedSuitabilityCertificate');
    });

    Route::prefix('replacement_staff')->as('replacement_staff.')->group(function(){
        Route::get('/create', [ReplacementStaffController::class, 'create'])->name('create');
        Route::post('/store', [ReplacementStaffController::class, 'store'])->name('store');
        Route::get('/{replacement_staff}/edit', [ReplacementStaffController::class, 'edit'])->name('edit');
        Route::put('/{replacement_staff}/update', [ReplacementStaffController::class, 'update'])->name('update');
        Route::get('/show_file/{replacement_staff}', [ReplacementStaffController::class, 'show_file'])->name('show_file');
        Route::get('/download/{replacement_staff}', [ReplacementStaffController::class, 'download'])->name('download');
        Route::prefix('profile')->name('profile.')->group(function(){
            Route::post('/{replacementStaff}/store', [ProfileController::class, 'store'])->name('store');
            Route::get('/download/{profile}', [ProfileController::class, 'download'])->name('download');
            Route::get('/show_file/{profile}', [ProfileController::class, 'show_file'])->name('show_file');
            Route::delete('{profile}/destroy', [ProfileController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('training')->name('training.')->group(function(){
            Route::post('/{replacementStaff}/store', [TrainingController::class, 'store'])->name('store');
            Route::get('/download/{training}', [TrainingController::class, 'download'])->name('download');
            Route::get('/show_file/{training}', [TrainingController::class, 'show_file'])->name('show_file');
            Route::delete('{training}/destroy', [TrainingController::class, 'destroy'])->name('destroy');
        });
    });

});


/** TODO: pasarlo al controller del usuario */
Route::post('/email/verification-notification/{user}', function (User $user) {
    $user->sendEmailVerificationNotification();
    return back()->with('success', 'El enlace de verificación se ha enviado al correo personal <b>'. $user->email_personal .'</b> para su confirmación.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');


/** TODO: no tiene auth */
Route::post('/{signaturesFlowId}/firma', [DigitalSignatureController::class,'signPdfFlow'])->name('signPdfFlow');
Route::post('/firma', [DigitalSignatureController::class,'signPdf'])->name('signPdf');
Route::get('/validador', [SignatureController::class,'verify'])->name('verifyDocument');
Route::get('/test-firma/{otp}', [DigitalSignatureController::class,'test']);


/* Replacepent Staff */
Route::prefix('replacement_staff')->as('replacement_staff.')->middleware('auth')->group(function(){
    Route::get('/', [ReplacementStaffController::class, 'index'])->name('index')->middleware(['role:Replacement Staff: admin|Replacement Staff: user rys']);
    Route::get('/{replacement_staff}/show_replacement_staff', [ReplacementStaffController::class, 'show_replacement_staff'])->name('show_replacement_staff');
    Route::get('/download_file/{replacement_staff}', [ReplacementStaffController::class, 'download'])->name('download_file');
    Route::get('/view_file/{replacement_staff}', [ReplacementStaffController::class, 'show_file'])->name('view_file');
    Route::prefix('staff_manage')->name('staff_manage.')->group(function(){
        Route::get('/', [StaffManageController::class, 'index'])->name('index');
        Route::get('/create', [StaffManageController::class, 'create'])->name('create');
        Route::post('/store', [StaffManageController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StaffManageController::class, 'edit'])->name('edit');
        Route::get('{organizational_unit_id}/destroy/{replacement_staff_id}', [StaffManageController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('view_profile')->name('view_profile.')->group(function(){
        Route::get('/download/{profile}', [ProfileController::class, 'download'])->name('download');
        Route::get('/show_file/{profile}', [ProfileController::class, 'show_file'])->name('show_file');
    });
    Route::prefix('view_training')->name('view_training.')->group(function(){
        Route::get('/download/{training}', [TrainingController::class, 'download'])->name('download');
        Route::get('/show_file/{training}', [TrainingController::class, 'show_file'])->name('show_file');
    });
    Route::prefix('request')->name('request.')->group(function(){
        Route::get('/', [RequestReplacementStaffController::class, 'index'])->name('index')->middleware('permission:Replacement Staff: assign request');
        Route::get('/assign_index', [RequestReplacementStaffController::class, 'assign_index'])->name('assign_index')->middleware('permission:Replacement Staff: technical evaluation');
        Route::get('/own_index', [RequestReplacementStaffController::class, 'own_index'])->name('own_index');
        Route::get('/personal_index', [RequestReplacementStaffController::class, 'personal_index'])->name('personal_index');
        Route::get('/pending_personal_index', [RequestReplacementStaffController::class, 'pending_personal_index'])->name('pending_personal_index');
        Route::get('/ou_index', [RequestReplacementStaffController::class, 'ou_index'])->name('ou_index');
        Route::get('/create', [RequestReplacementStaffController::class, 'create'])->name('create');
        Route::get('/{requestReplacementStaff}/create_extension', [RequestReplacementStaffController::class, 'create_extension'])->name('create_extension');
        Route::post('/store', [RequestReplacementStaffController::class, 'store'])->name('store');
        Route::post('/{requestReplacementStaff}/store_extension', [RequestReplacementStaffController::class, 'store_extension'])->name('store_extension');
        Route::get('/{requestReplacementStaff}/edit', [RequestReplacementStaffController::class, 'edit'])->name('edit');
        Route::put('/{requestReplacementStaff}/update', [RequestReplacementStaffController::class, 'update'])->name('update');
        Route::get('/to_select/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'to_select'])->name('to_select');
        Route::get('/to_sign', [RequestReplacementStaffController::class, 'to_sign'])->name('to_sign');
        Route::get('/show_file/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'show_file'])->name('show_file');
        Route::get('/download/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'download'])->name('download');
        Route::get('/show_verification_file/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'show_verification_file'])->name('show_verification_file');
        Route::get('/download_verification/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'download_verification'])->name('download_verification');
        Route::prefix('sign')->name('sign.')->group(function(){
            Route::put('/{requestSign}/{status}/{requestReplacementStaff}/update', [RequestSignController::class, 'update'])->name('update');
        });
        Route::prefix('technical_evaluation')->name('technical_evaluation.')->group(function(){
            Route::get('/{technicalEvaluation}/edit', [TechnicalEvaluationController::class, 'edit'])->name('edit');
            Route::post('/store/{requestReplacementStaff}', [TechnicalEvaluationController::class, 'store'])->name('store');
            Route::post('/finalize_selection_process/{technicalEvaluation}', [TechnicalEvaluationController::class, 'finalize_selection_process'])->name('finalize_selection_process');
            Route::prefix('commission')->name('commission.')->group(function(){
                Route::post('/store/{technicalEvaluation}', [CommissionController::class, 'store'])->name('store');
                Route::delete('{commission}/destroy', [CommissionController::class, 'destroy'])->name('destroy');
            });
            Route::prefix('applicant')->name('applicant.')->group(function(){
                Route::post('/store/{technicalEvaluation}', [ApplicantController::class, 'store'])->name('store');
                Route::put('/{applicant}/update', [ApplicantController::class, 'update'])->name('update');
                Route::put('/{applicant}/update_to_select', [ApplicantController::class, 'update_to_select'])->name('update_to_select');
                Route::delete('{applicant}/destroy', [ApplicantController::class, 'destroy'])->name('destroy');
                Route::post('/decline_selected_applicant/{applicant}', [ApplicantController::class, 'decline_selected_applicant'])->name('decline_selected_applicant');
            });
            Route::prefix('file')->name('file.')->group(function(){
                Route::post('/store/{technicalEvaluation}', [TechnicalEvaluationFileController::class, 'store'])->name('store');
                Route::delete('{technicalEvaluationFile}/destroy', [TechnicalEvaluationFileController::class, 'destroy'])->name('destroy');
                Route::get('/show_file/{technicalEvaluationFile}', [TechnicalEvaluationFileController::class, 'show_file'])->name('show_file');
                Route::get('/download/{technicalEvaluationFile}', [TechnicalEvaluationFileController::class, 'download'])->name('download');
            });
            Route::get('/create_document/{requestReplacementStaff}', [TechnicalEvaluationController::class, 'create_document'])->name('create_document');
        });

    });

    Route::prefix('contact_record')->name('contact_record.')->middleware(['role:Replacement Staff: admin|Replacement Staff: user rys'])->group(function(){
        Route::get('/{staff}', [ContactRecordController::class, 'index'])->name('index');
        Route::get('/{staff}/create/', [ContactRecordController::class, 'create'])->name('create');
        Route::post('/{staff}/store', [ContactRecordController::class, 'store'])->name('store');
        // Route::get('/{id}/edit', [StaffManageController::class, 'edit'])->name('edit');
        // Route::get('{organizational_unit_id}/destroy/{replacement_staff_id}', [StaffManageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reports')->name('reports.')->group(function(){
        //Route::get('/replacement_staff_selected_report', [ReplacementStaffController::class, 'replacement_staff_selected_report'])->name('replacement_staff_selected_report');
        Route::get('/replacement_staff_historical', [ReplacementStaffController::class, 'replacement_staff_historical'])->name('replacement_staff_historical');
    });

    Route::prefix('profile')->name('profile.')->group(function(){
        // Route::post('/{replacementStaff}/store', [ProfileController::class, 'store'])->name('store');
        // Route::get('/download/{profile}', [ProfileController::class, 'download'])->name('download');
        // Route::get('/show_file/{profile}', [ProfileController::class, 'show_file'])->name('show_file');
        //Route::delete('{profile}/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Route::prefix('experience')->name('experience.')->group(function(){
    //     Route::post('/{replacementStaff}/store', [ExperienceController::class, 'store'])->name('store');
    //     Route::get('/download/{experience}', [ExperienceController::class, 'download'])->name('download');
    //     Route::get('/show_file/{experience}', [ExperienceController::class, 'show_file'])->name('show_file');
    //     Route::delete('{experience}/destroy', [ExperienceController::class, 'destroy'])->name('destroy');
    // });
    // Route::prefix('language')->name('language.')->group(function(){
    //     Route::post('/{replacementStaff}/store', [languageController::class, 'store'])->name('store');
    //     Route::get('/download/{language}', [languageController::class, 'download'])->name('download');
    //     Route::get('/show_file/{language}', [languageController::class, 'show_file'])->name('show_file');
    //     Route::delete('{language}/destroy', [languageController::class, 'destroy'])->name('destroy');
    // });

    Route::group(['middleware' => ['role:Replacement Staff: admin']], function () {
      Route::prefix('manage')->name('manage.')->group(function(){
          Route::prefix('profession')->name('profession.')->group(function(){
              Route::get('/', [ProfessionManageController::class, 'index'])->name('index');
              Route::post('/store', [ProfessionManageController::class, 'store'])->name('store');
              Route::get('/{professionManage}/edit', [ProfessionManageController::class, 'edit'])->name('edit');
              Route::put('{professionManage}/update', [ProfessionManageController::class, 'update'])->name('update');
              Route::delete('{professionManage}/destroy', [ProfessionManageController::class, 'destroy'])->name('destroy');
          });
          Route::prefix('profile')->name('profile.')->group(function(){
              Route::get('/', [ProfileManageController::class, 'index'])->name('index');
              Route::post('/store', [ProfileManageController::class, 'store'])->name('store');
              Route::get('/{profileManage}/edit', [ProfileManageController::class, 'edit'])->name('edit');
              Route::put('{profileManage}/update', [ProfileManageController::class, 'update'])->name('update');
              Route::delete('{profileManage}/destroy', [ProfileManageController::class, 'destroy'])->name('destroy');
          });
          Route::prefix('legal_quality')->name('legal_quality.')->group(function(){
              Route::get('/', [LegalQualityManageController::class, 'index'])->name('index');
              Route::post('/store', [LegalQualityManageController::class, 'store'])->name('store');
              Route::get('/{legalQualityManage}/edit', [LegalQualityManageController::class, 'edit'])->name('edit');
              Route::post('{legalQualityManage}/assign_fundament', [LegalQualityManageController::class, 'assign_fundament'])->name('assign_fundament');
              // Route::delete('{profileManage}/destroy', [ProfileManageController::class, 'destroy'])->name('destroy');
          });
          Route::prefix('fundament')->name('fundament.')->group(function(){
              Route::get('/', [RstFundamentManageController::class, 'index'])->name('index');
              Route::post('/store', [RstFundamentManageController::class, 'store'])->name('store');
              Route::get('/{rstFundamentManage}/edit', [RstFundamentManageController::class, 'edit'])->name('edit');
              Route::post('{rstFundamentManage}/assign_fundament', [RstFundamentManageController::class, 'assign_fundament'])->name('assign_fundament');
              // Route::delete('{profileManage}/destroy', [ProfileManageController::class, 'destroy'])->name('destroy');
          });
      });
    });
});
/** Fin Replacement Staff */


/** Inicio Recursos */
Route::prefix('resources')->name('resources.')->namespace('Resources')->middleware('auth')->group(function () {

    Route::get('report', [App\Http\Controllers\Resources\ReportController::class,'report'])->name('report');

    Route::prefix('telephones')->name('telephone.')->group(function () {
        Route::get('/', [TelephoneController::class,'index'])->name('index');
        Route::get('create', [TelephoneController::class,'create'])->name('create');
        Route::post('store', [TelephoneController::class,'store'])->name('store');
        Route::get('{telephone}/edit', [TelephoneController::class,'edit'])->name('edit');
        Route::put('{telephone}/update', [TelephoneController::class,'update'])->name('update');
        Route::delete('{telephone}/destroy', [TelephoneController::class,'destroy'])->name('destroy');
    });
    Route::prefix('computers')->name('computer.')->group(function () {
        Route::get('/', [ComputerController::class,'index'])->name('index');
        Route::get('create', [ComputerController::class,'create'])->name('create');
        Route::post('store', [ComputerController::class,'store'])->name('store');
        Route::get('{computer}/edit', [ComputerController::class,'edit'])->name('edit');
        Route::put('{computer}/update', [ComputerController::class,'update'])->name('update');
        Route::delete('{computer}/destroy', [ComputerController::class,'destroy'])->name('destroy');
    });
    Route::prefix('printers')->name('printer.')->group(function () {
        Route::get('/', [PrinterController::class,'index'])->name('index');
        Route::get('create', [PrinterController::class,'create'])->name('create');
        Route::post('store', [PrinterController::class,'store'])->name('store');
        Route::get('{printer}/edit', [PrinterController::class,'edit'])->name('edit');
        Route::put('{printer}/update', [PrinterController::class,'update'])->name('update');
        Route::delete('{printer}/destroy', [PrinterController::class,'destroy'])->name('destroy');
    });
    Route::prefix('wingles')->name('wingle.')->group(function () {
        Route::get('/', [WingleController::class,'index'])->name('index');
        Route::get('create', [WingleController::class,'create'])->name('create');
        Route::post('store', [WingleController::class,'store'])->name('store');
        Route::get('{wingle}/edit', [WingleController::class,'edit'])->name('edit');
        Route::put('{wingle}/update', [WingleController::class,'update'])->name('update');
        Route::delete('{wingle}/destroy', [WingleController::class,'destroy'])->name('destroy');
    });
    Route::prefix('mobiles')->name('mobile.')->group(function () {
        Route::get('/', [MobileController::class,'index'])->name('index');
        Route::get('create', [MobileController::class,'create'])->name('create');
        Route::post('store', [MobileController::class,'store'])->name('store');
        Route::get('{mobile}/edit', [MobileController::class,'edit'])->name('edit');
        Route::put('{mobile}/update', [MobileController::class,'update'])->name('update');
        Route::delete('{mobile}/destroy', [MobileController::class,'destroy'])->name('destroy');
    });
});
/** Fin Recursos */

/** Inicio Agreements */
Route::prefix('agreements')->as('agreements.')->middleware('auth')->group(function () {
    Route::get('/{agreement}/accountability/create', [AccountabilityController::class,'create'])->name('accountability.create');
    Route::post('/{agreement}/accountability', [AccountabilityController::class,'store'])->name('accountability.store');
    Route::get('/{agreement}/accountability', [AccountabilityController::class,'index'])->name('accountability.index');
    Route::get('/{agreement}/accountability/{accountability}/create', [AccountabilityDetailController::class,'create'])->name('accountability.detail.create');
    Route::post('/{agreement}/accountability/{accountability}', [AccountabilityDetailController::class,'store'])->name('accountability.detail.store');

    Route::delete('/agreements', [AgreementController::class,'destroy'])->name('destroy');


    Route::post('stage', [StageController::class,'store'])->name('stage.store');
    Route::put('/stage/{agreement_stage}', [AgreementController::class,'updateStage'])->name('stage.update');
    Route::get('/stage/download/{file}', [StageController::class,'download'])->name('stage.download');

    Route::get('/download/{file}', [AgreementController::class,'download'])->name('download');
    Route::get('/downloadAgree/{file}', [AgreementController::class,'downloadAgree'])->name('downloadAgree');
    Route::get('/downloadRes/{file}', [AgreementController::class,'downloadRes'])->name('downloadRes');

    Route::get('/preview/{agreement}', [AgreementController::class,'preview'])->name('preview');

    Route::resource('addendums', AddendumController::class);
    Route::post('/addendum/createWord/{addendum}/type/{type}', [WordTestController::class,'createWordDocxAddendum'])->name('addendum.createWord');
    Route::post('/addendum/createWordWithdrawal/{addendum}/type/{type}', [WordWithdrawalAgreeController::class,'createWordDocxAddendum'])->name('addendum.createWordWithdrawal');
    Route::get('/addendum/downloadRes/{addendum}', [AddendumController::class,'downloadRes'])->name('addendum.downloadRes');
    Route::get('/addendum/sign/{addendum}/type/{type}', [AddendumController::class,'sign'])->name('addendum.sign');
    Route::get('/addendum/preview/{addendum}', [AddendumController::class,'preview'])->name('addendum.preview');
    Route::resource('programs', App\Http\Controllers\Agreements\ProgramController::class);
    Route::prefix('programs')->name('programs.')->group(function () {
        Route::resource('resolutions', ProgramResolutionController::class);
        Route::get('resolution/createWord/{program_resolution}', [WordTestController::class,'createWordDocxResProgram'])->name('resolution.createWord');
        Route::get('resolution/download/{program_resolution}', [ProgramResolutionController::class,'download'])->name('resolution.download');
        Route::post('resolution/amount/{program_resolution}', [ProgramResolutionController::class,'storeAmount'])->name('resolution.amount.store');
        Route::put('resolution/amount/{resolution_amount}', [ProgramResolutionController::class,'updateAmount'])->name('resolution.amount.update');
        Route::delete('resolution/amount/{resolution_amount}', [ProgramResolutionController::class,'destroyAmount'])->name('resolution.amount.destroy');
    });
    Route::resource('municipalities', MunicipalityController::class);
    Route::resource('signers', SignerController::class);
    Route::put('/amount/{agreement_amount}', [AgreementController::class,'updateAmount'])->name('amount.update');
    Route::delete('/amount/{agreement_amount}', [AgreementController::class,'destroyAmount'])->name('amount.destroy');
    Route::put('/quota/{agreement_quota}', [AgreementController::class,'updateQuota'])->name('quota.update');
    Route::put('/quotaAutomatic/{agreement_quota}', [AgreementController::class,'updateAutomaticQuota'])->name('quotaAutomatic.update');

    Route::get('tracking', [AgreementController::class,'indexTracking'])->name('tracking.index');
    //Route::get('createWord',[WordTestController::class,'createWordDocx'])->name('createWord.index');
    Route::get('/createWord/{agreement}', [WordTestController::class,'createWordDocx'])->name('createWord');
    Route::post('/createWordRes/{agreement}', [WordTestController::class,'createResWordDocx'])->name('createWordRes');
    Route::get('/createWordWithdrawal/{agreement}', [WordWithdrawalAgreeController::class,'createWordDocx'])->name('createWordWithdrawal');
    Route::post('/createWordResWithdrawal/{agreement}', [WordWithdrawalAgreeController::class,'createResWordDocx'])->name('createWordResWithdrawal');
    Route::get('/createWordCollaboration/{agreement}', [WordCollaborationAgreeController::class,'createWordDocx'])->name('createWordCollaboration');
    Route::post('/createWordResCollaboration/{agreement}', [WordCollaborationAgreeController::class,'createResWordDocx'])->name('createWordResCollaboration');
    Route::get('/createWordMandate/{agreement}', [WordMandateAgreeController::class,'createWordDocx'])->name('createWordMandate');
    Route::get('/createWordMandatePFC/{agreement}', [WordMandatePFCAgreeController::class,'createWordDocx'])->name('createWordMandatePFC');
    Route::get('/sign/{agreement}/type/{type}', [AgreementController::class,'sign'])->name('sign');
});
/** Fin Agreements */

/** TODO #51 agrupar con middleware auth y revisar rutas que no se ocupen */
/** Programación Númerica APS */
Route::resource('programmings', ProgrammingController::class)->middleware('auth');
Route::put('programmingStatus/{id}', [ProgrammingController::class,'updateStatus'])->middleware('auth')->name('programmingStatus.update');

Route::resource('programmingitems', ProgrammingItemController::class)->middleware('auth');
Route::post('/programmingitemsclone/{id}', [ProgrammingItemController::class,'clone'])->name('programmingitems.clone');

Route::resource('communefiles', CommuneFileController::class)->middleware('auth');
Route::get('/downloadFileA/{file}', [CommuneFileController::class,'download'])->name('programmingFile.download');
Route::get('/downloadFileB/{file}', [CommuneFileController::class,'downloadFileB'])->name('programmingFile.downloadFileB');
Route::get('/downloadFileC/{file}', [CommuneFileController::class,'downloadFileC'])->name('programmingFile.downloadFileC');

Route::resource('reviews', ProgrammingReviewController::class)->middleware('auth');
Route::resource('reviewItems', ReviewItemController::class)->middleware('auth');
Route::put('reviewItemsRect/{id}', [ReviewItemController::class,'updateRect'])->middleware('auth')->name('reviewItemsRect.update');

Route::resource('programmingdays', ProgrammingDayController::class)->middleware('auth');

Route::resource('professionals', ProfessionalController::class)->middleware('auth');
Route::resource('actiontypes', ActionTypeController::class)->middleware('auth');
Route::resource('ministerialprograms', MinisterialProgramController::class)->middleware('auth');

Route::resource('activityprograms', ActivitiesProgramController::class)->middleware('auth');
Route::resource('activityitems', ActivitiesItemController::class)->middleware('auth');

Route::resource('professionalhours', ProfessionalHourController::class)->middleware('auth');

Route::resource('trainingitems', TrainingsItemController::class)->middleware('auth');

Route::resource('pendingitems', ProgrammingActivityItemController::class)->middleware('auth');

//Reportes de Programación Númerica APS
Route::get('reportConsolidated', [ProgrammingReportController::class,'reportConsolidated'])->middleware('auth')->name('programming.reportConsolidated');
Route::get('reportConsolidatedSep', [ProgrammingReportController::class,'reportConsolidatedSep'])->middleware('auth')->name('programming.reportConsolidatedSep');

//Reportes Observaciones de Programación Númerica APS
Route::get('reportObservation', [ProgrammingReportController::class,'reportObservation'])->middleware('auth')->name('programming.reportObservation');

//End Programación Númerica APS


Route::resource('agreements', AgreementController::class)->middleware('auth');

/** assigments */
Route::resource('assigment', AssigmentController::class)->middleware('auth');
Route::post('assigment.import', [AssigmentController::class,'import'])->name('assigment.import');


Route::prefix('rrhh')->as('rrhh.')->group(function () {
    Route::get('{user}/roles', [RoleController::class,'index'])->name('roles.index')->middleware('auth');
    Route::post('{user}/roles', [RoleController::class,'attach'])->name('roles.attach')->middleware('auth');


    /** TODO: #50 incorporar auth en el grupo e importar controllers al comienzo del archivo */
    /** Inicio Shift Managment */
    Route::prefix('shift-management')->group(function () {

        Route::get('/next', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'goToNextMonth'])->name('shiftManag.nextMonth')->middleware('auth');
        Route::get('/prev', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'goToPreviousMonth'])->name('shiftManag.prevMonth')->middleware('auth');

        Route::get('/myshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'myShift'])->name('shiftManag.myshift')->middleware('auth');
        Route::get('/seeShiftControlForm', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'seeShiftControlForm'])->name('shiftManag.seeShiftControlForm')->middleware('auth');


        Route::get('/closeshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'closeShift'])->name('shiftManag.closeShift')->middleware('auth');
        Route::post('/closeshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'closeShift'])->name('shiftManag.closeShift')->middleware('auth');
        Route::get('/closeshift/download/{id}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'downloadCloseInXls'])->name('shiftManag.closeShift.download')->middleware('auth');

        Route::post('/closeshift/first', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'firstConfirmation'])->name('shiftManag.closeShift.firstConfirmation')->middleware('auth');
        Route::post('/closeshift/close', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'closeDaysConfirmation'])->name('shiftManag.closeShift.closeConfirmation')->middleware('auth');

        Route::post('/closeshift/saveclosedate/{new?}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'saveClose'])->name('shiftManag.closeShift.saveDate')->middleware('auth');

        Route::post('/shiftupdate', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'changeShiftUserCommentary'])->name('shiftManag.shiftupdate')->middleware('auth');

        Route::get('/shiftreports', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'shiftReports'])->name('shiftManag.shiftReports')->middleware('auth');
        Route::post('/shiftreports', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'shiftReports'])->name('shiftManag.shiftReports')->middleware('auth');
        Route::get('/shiftreports/XLSdownload', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'shiftReportsXLSDownload'])->name('shiftManag.shiftReportsXLSdownload')->middleware('auth');

        Route::get('/shiftdashboard', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'shiftDashboard'])->name('shiftManag.shiftDashboard')->middleware('auth');
        Route::get('/available-shifts', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'availableShifts'])->name('shiftManag.availableShifts')->middleware('auth');
        Route::post('/available-shifts/applyfor', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'applyForAvailableShifts'])->name('shiftManag.availableShifts.applyfor')->middleware('auth');
        Route::post('/available-shifts/cancelDay', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'cancelShiftRequest'])->name('shiftManag.availableShifts.cancelRequest')->middleware('auth');
        Route::post('/available-shifts/approvalRequest', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'approveShiftRequest'])->name('shiftManag.availableShifts.approvalRequest')->middleware('auth');
        Route::post('/available-shifts/rejectRequest', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'rejectShiftRequest'])->name('shiftManag.availableShifts.rejectRequest')->middleware('auth');
        Route::get('/myshift/confirm/{day}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'myShiftConfirm'])->name('shiftManag.myshift.confirmDay')->middleware('auth');
        Route::get('/myshift/reject/{day}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'myShiftReject'])->name('shiftManag.myshift.rejectDay')->middleware('auth');

        Route::get('/reject/{day}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'adminShiftConfirm'])->name('shiftManag.confirmDay')->middleware('auth');


        Route::post('/myshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'myShift'])->name('shiftManag.myshiftfiltered')->middleware('auth');



        Route::post('/shift-control-form/download', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'downloadShiftControlInPdf'])->name('shiftManag.downloadform')->middleware('auth');


        Route::post('/', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'indexfiltered'])->name('shiftManag.indexF')->middleware('auth');
        Route::post('/assign', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'assignStaff'])->name('shiftsTypes.assign')->middleware('auth');
        Route::post('/deleteassign', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'assignStaff'])->name('shiftsTypes.deleteassign')->middleware('auth');
        Route::get('/downloadShiftInXls', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'downloadShiftInXls'])->name('shiftsTypes.downloadShiftInXls')->middleware('auth');

        Route::get('/shiftstypes', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'shiftstypesindex'])->name('shiftsTypes.index')->middleware('auth');
        Route::get('/newshifttype', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'index'])->name('shiftsTypes.new')->middleware('auth');
        Route::get('/newshifttype/', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'newshifttype'])->name('shiftsTypes.create')->middleware('auth');
        Route::get('/editshifttype/{id}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'editshifttype'])->name('shiftsTypes.edit')->middleware('auth');
        Route::post('/updateshifttype', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'updateshifttype'])->name('shiftsTypes.update')->middleware('auth');
        Route::post('/storeshifttype', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'storenewshift'])->name('shiftsTypes.store')->middleware('auth');



        Route::get('/{groupname?}', [App\Http\Controllers\Rrhh\ShiftManagementController::class,'index'])->name('shiftManag.index')->middleware('auth');
    });
    /** Fin Shift Managment */

    Route::prefix('attendance')->name('attendance.')->middleware('auth')->group(function() {
        Route::get('/',[AttendanceController::class,'index'])->name('index');
        Route::get('/import',[AttendanceController::class,'import'])->name('import');
        Route::post('/store',[AttendanceController::class,'store'])->name('store');
    });

    Route::prefix('service-request')->name('service-request.')->middleware('auth')->group(function () {
        // Rutas de service request
        Route::get('/test', [ServiceRequestController::class, 'test'])->name('test');
        Route::get('/home', function () { return view('service_requests.home'); })->name('home');

        Route::match(['get', 'post'],'/user', [ServiceRequestController::class, 'user'])->name('user');

        /** descomposición del resource */
        Route::get('/', [ServiceRequestController::class, 'index'])->name('index');
        Route::get('/create', [ServiceRequestController::class, 'create'])->name('create');
        Route::post('/store', [ServiceRequestController::class, 'store'])->name('store');
        Route::get('/{serviceRequest}/edit', [ServiceRequestController::class, 'edit'])->name('edit');
        Route::put('/{serviceRequest}/update', [ServiceRequestController::class, 'update'])->name('update');
        Route::delete('{serviceRequest}/destroy', [ServiceRequestController::class, 'destroy'])->name('destroy');

        Route::get('/transfer-requests', [ServiceRequestController::class, 'transfer_requests'])->name('transfer_requests');
        Route::get('/change_signature_flow_view', [ServiceRequestController::class, 'change_signature_flow_view'])->name('change_signature_flow_view');
        Route::post('/change-signature-flow', [ServiceRequestController::class, 'change_signature_flow'])->name('change_signature_flow');
        Route::post('/delete-signature-flow', [ServiceRequestController::class, 'delete_signature_flow'])->name('delete_signature_flow');
        Route::post('/derive', [ServiceRequestController::class, 'derive'])->name('derive');
        Route::get('/accept_all_requests', [ServiceRequestController::class, 'accept_all_requests'])->name('accept_all_requests');

        Route::post('/destroy-with-parameters', [ServiceRequestController::class, 'destroy_with_parameters'])->name('destroy-with-parameters');
        Route::get('/pending-requests', [ServiceRequestController::class, 'pending_requests'])->name('pending-requests');

        Route::get('/aditional-data-list', [ServiceRequestController::class, 'aditional_data_list'])->name('aditional_data_list');
        Route::put('/update-aditional-data/{serviceRequest}', [ServiceRequestController::class, 'update_aditional_data'])->name('update_aditional_data');

        Route::get('/signed-budget-availability-pdf/{serviceRequest}', [ServiceRequestController::class, 'signedBudgetAvailabilityPDF'])->name('signed-budget_availability-pdf');
        Route::get('/callback-firma-budget-availability/{message}/{modelId}/{signaturesFile?}', [ServiceRequestController::class, 'callbackFirmaBudgetAvailability'])->name('callbackFirmaBudgetAvailability');


        Route::prefix('parameters')->name('parameters.')->middleware('auth')->group(function () {

            Route::prefix('1121')->name('1121.')->group(function () {
                Route::get('/', [Denomination1121Controller::class, 'index'])->name('index');
                Route::get('/create', [Denomination1121Controller::class, 'create'])->name('create');
                Route::post('/store', [Denomination1121Controller::class, 'store'])->name('store');
                Route::get('/{denomination1121}/edit', [Denomination1121Controller::class, 'edit'])->name('edit');
                Route::put('/{denomination1121}/update', [Denomination1121Controller::class, 'update'])->name('update');
                Route::delete('{denomination1121}/destroy', [Denomination1121Controller::class, 'destroy'])->name('destroy');
            });

            Route::prefix('formula')->name('formula.')->group(function () {
                Route::get('/', [DenominationFormulaController::class, 'index'])->name('index');
                Route::get('/create', [DenominationFormulaController::class, 'create'])->name('create');
                Route::post('/store', [DenominationFormulaController::class, 'store'])->name('store');
                Route::get('/{denominationFormula}/edit', [DenominationFormulaController::class, 'edit'])->name('edit');
                Route::put('/{denominationFormula}/update', [DenominationFormulaController::class, 'update'])->name('update');
                Route::delete('{denominationFormula}/destroy', [DenominationFormulaController::class, 'destroy'])->name('destroy');
            });
        });



        Route::prefix('fulfillment')->name('fulfillment.')->group(function () {
            // descomposición del resource
            Route::get('/', [FulfillmentController::class, 'index'])->name('index');
            Route::post('/store', [FulfillmentController::class, 'store'])->name('store');
            Route::put('/{fulfillment}/update', [FulfillmentController::class, 'update'])->name('update');
            Route::delete('{fulfillment}/destroy', [FulfillmentController::class, 'destroy'])->name('destroy');
            // fin descomposición
            Route::get('/edit/{serviceRequest}', [FulfillmentController::class, 'edit_fulfillment'])->name('edit');
            Route::get('/save-approbed-fulfillment/{serviceRequest}', [FulfillmentController::class, 'save_approbed_fulfillment'])->name('save_approbed_fulfillment');
            Route::get('/confirm-fulfillment-by-sign-position/{Fulfillment}/{approbed?}', [FulfillmentController::class, 'confirmFulfillmentBySignPosition'])->name('confirm_Fulfillment_By_SignPosition');
            Route::get('/download-invoice/{fulfillment}/{timestamp?}', [FulfillmentController::class, 'downloadInvoice'])->name('download_invoice');
            Route::get('/download-resolution/{serviceRequest}', [FulfillmentController::class, 'downloadResolution'])->name('download_resolution');
            Route::get('/certificate-pdf/{fulfillment}/{user?}', [FulfillmentController::class, 'certificatePDF'])->name('certificate-pdf');
            Route::get('/signed-certificate-pdf/{fulfillment}/{timestamp?}', [FulfillmentController::class, 'signedCertificatePDF'])->name('signed-certificate-pdf');
            Route::get('/delete-signed-certificate-pdf/{fulfillment}', [FulfillmentController::class, 'deletesignedCertificatePDF'])->name('delete-signed-certificate-pdf');
            Route::get('/delete-responsable-vb/{fulfillment}', [FulfillmentController::class, 'deleteResponsableVB'])->name('delete-responsable-vb');
            //eliminar palabra fulfiment en URL y en metodo
            Route::get('/confirm-fulfillment/{fulfillment}', [FulfillmentController::class, 'confirmFulfillment'])->name('confirm-Fulfillment');
            Route::get('/refuse-fulfillment/{fulfillment}', [FulfillmentController::class, 'refuseFulfillment'])->name('refuse-Fulfillment');
            Route::post('/update-paid-values', [FulfillmentController::class, 'updatePaidValues'])->name('update-paid-values');
            Route::get('/add_fulfillment/{serviceRequest}', [FulfillmentController::class, 'add_fulfillment'])->name('add_fulfillment');

            Route::prefix('item')->name('item.')->group(function () {
                // descomposición del resource
                Route::get('/', [FulfillmentItemController::class, 'index'])->name('index');
                Route::post('/store', [FulfillmentItemController::class, 'store'])->name('store');
                Route::put('/{fulfillment}/update', [FulfillmentItemController::class, 'update'])->name('update');
                Route::delete('{fulfillmentItem}/destroy', [FulfillmentItemController::class, 'destroy'])->name('destroy');
            });


            Route::prefix('attachment')->name('attachment.')->group(function () {
                //descomposición del attachment
                Route::post('/{var}/store', [AttachmentController::class, 'store'])->name('store');
                Route::get('/{attachment}/show', [AttachmentController::class, 'show'])->name('show');
                Route::get('/{attachment}/download', [AttachmentController::class, 'download'])->name('download');
                Route::delete('/{attachment}/destroy', [AttachmentController::class, 'destroy'])->name('destroy');

            });



        });

        Route::prefix('report')->name('report.')->group(function () {
            // Rutas a los reportes
            Route::get('/to-pay', [App\Http\Controllers\ServiceRequests\ReportController::class, 'toPay'])->name('to-pay');
            Route::get('/payed', [ReportController::class, 'payed'])->name('payed');
            Route::get('/pay-rejected', [ReportController::class, 'payRejected'])->name('pay-rejected');
            Route::get('/without-bank-details', [ReportController::class, 'withoutBankDetails'])->name('without-bank-details');
            Route::get('/with-bank-details', [ReportController::class, 'withBankDetails'])->name('with-bank-details');
            Route::get('/exportCsv', [ReportController::class, 'exportCsv'])->name('exportCsv');
            Route::get('/pending-resolutions', [ReportController::class, 'pendingResolutions'])->name('pending-resolutions');
            Route::get('/contract', [ReportController::class, 'contract'])->name('contract');
            Route::get('/duplicate-contracts', [ReportController::class, 'duplicateContracts'])->name('duplicate-contracts');
            Route::get('/overlapping-contracts', [ReportController::class, 'overlappingContracts'])->name('overlapping-contracts');
            Route::get('/service-request-continuity', [ReportController::class, 'service_request_continuity'])->name('service-request-continuity');
            Route::get('/resolution-pdf/{ServiceRequest}', [ReportController::class, 'resolutionPDF'])->name('resolution-pdf');
            Route::get('/resolution-pdf-hsa/{ServiceRequest}', [ReportController::class, 'resolutionPDFhsa'])->name('resolution-pdf-hsa');
            Route::get('/bank-payment-file/{establishment_id?}', [ReportController::class, 'bankPaymentFile'])->name('bank-payment-file');
            Route::get('/with-resolution-file', [ReportController::class, 'indexWithResolutionFile'])->name('with-resolution-file');
            Route::get('/without-resolution-file', [ReportController::class, 'indexWithoutResolutionFile'])->name('without-resolution-file');
            Route::get('/budget-availability/{serviceRequest}', [ReportController::class, 'budgetAvailability'])->name('budget-availability');
            Route::get('/compliance', [ReportController::class, 'compliance'])->name('compliance');
            Route::get('/compliance-export', [ReportController::class, 'complianceExport'])->name('compliance-export');

            Route::get('/fulfillment/pending/{who}', [ReportController::class, 'pending'])->name('fulfillment-pending');
            // Route::get('/fulfillment/rrhh', [ReportController::class, 'pendingRrhh'])->name('pending-rrhh');
            // Route::get('/fulfillment/finance', [ReportController::class, 'pendingFinance'])->name('pending-finance');

            //pasar a reports
            // Route::get('/consolidated-data', [ServiceRequestController::class, 'consolidated_data'])->name('consolidated_data');
            // Route::get('/export-sirh', [ServiceRequestController::class, 'export_sirh'])->name('export_sirh');
            // Route::get('/export-sirh-txt', [ServiceRequestController::class, 'export_sirh_txt'])->name('export-sirh-txt');
            //pasar a reports
            Route::get('/consolidated-data', [ServiceRequestController::class, 'consolidated_data'])->name('consolidated_data');
            // Route::get('/export-sirh', [ServiceRequestController::class, 'export_sirh'])->name('export_sirh');
            Route::get('/export-sirh', [ReportController::class, 'export_sirh'])->name('export_sirh');
            Route::get('/export-sirh-txt', [ReportController::class, 'export_sirh_txt'])->name('export-sirh-txt');
        });

        Route::prefix('signature-flow')->name('signature-flow.')->group(function () {
            // Rutas a signature flow
            // ¿solamente tiene store?
            Route::post('/store', [SignatureFlowController::class, 'store'])->name('store');
        });
    });

    Route::resource('authorities', AuthorityController::class)->middleware(['auth']);

    Route::prefix('organizational-units')->name('organizational-units.')->group(function () {
        Route::get('/', [OrganizationalUnitController::class,'index'])->name('index')->middleware('auth');
        Route::get('/create', [OrganizationalUnitController::class,'create'])->name('create')->middleware('auth');
        Route::post('/store', [OrganizationalUnitController::class,'store'])->name('store')->middleware('auth');
        Route::get('{organizationalUnit}/edit', [OrganizationalUnitController::class,'edit'])->name('edit')->middleware('auth');
        Route::put('{organizationalUnit}', [OrganizationalUnitController::class,'update'])->name('update')->middleware('auth');
        Route::delete('{organizationalUnit}/destroy', [OrganizationalUnitController::class,'destroy'])->name('destroy')->middleware('auth');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('ou/{ou_id?}', [UserController::class,'getFromOu'])->name('get.from.ou')->middleware('auth');
        Route::get('autority/{ou_id?}', [UserController::class,'getAutorityFromOu'])->name('get.autority.from.ou')->middleware('auth');
        Route::put('{user}/password', [UserController::class,'resetPassword'])->name('password.reset')->middleware('auth');
        Route::get('{user}/switch', [UserController::class,'switch'])->name('switch')->middleware('auth');
        Route::get('directory', [UserController::class,'directory'])->name('directory');
        Route::get('/', [UserController::class,'index'])->name('index')->middleware('auth');
        Route::get('/create', [UserController::class,'create'])->name('create')->middleware('auth');
        Route::post('/', [UserController::class,'store'])->name('store')->middleware('auth');
        Route::get('/{user}/edit', [UserController::class,'edit'])->name('edit')->middleware('auth');
        Route::put('/{user}', [UserController::class,'update'])->name('update')->middleware('auth');
        Route::delete('/{user}', [UserController::class,'destroy'])->name('destroy')->middleware('auth');

        Route::prefix('service_requests')->name('service_requests.')->group(function () {
            Route::get('/', [UserController::class,'index_sr'])->name('index')->middleware('auth');
            Route::get('/create', [UserController::class,'create_sr'])->name('create')->middleware('auth');
            Route::post('/', [UserController::class,'store_sr'])->name('store')->middleware('auth');
            Route::get('/{user}/edit', [UserController::class,'edit_sr'])->name('edit')->middleware('auth');
            Route::put('/{user}', [UserController::class,'update_sr'])->name('update')->middleware('auth');
            Route::delete('/{user}', [UserController::class,'destroy_sr'])->name('destroy')->middleware('auth');

            /** TODO que hace esto? */
            Route::prefix('rrhh')->as('rrhh.')->group(function () {

            });
        });
    });
});

Route::prefix('parameters')->as('parameters.')->middleware('auth')->group(function () {
    Route::get('/', [ParameterController::class, 'welcome'])->name('welcome');
    Route::get('/all', ParameterIndex::class)->name('index');
    Route::get('/create', ParameterCreate::class)->name('create');
    Route::get('/{parameter}/edit', ParameterEdit::class)->name('edit');
    Route::put('/{parameter}', [ParameterController::class,'update'])->name('update');
    Route::get('drugs', [ParameterController::class,'indexDrugs'])->name('drugs')->middleware(['role:Drugs: admin']);
    //Route::resource('permissions', PermissionController::class);
    Route::prefix('permissions')->as('permissions.')->group(function () {
        Route::get('/create/{guard}', [PermissionController::class,'create'])->name('create');
        Route::post('/store', [PermissionController::class,'store'])->name('store');
        Route::get('/{guard}', [PermissionController::class,'index'])->name('index');
        Route::get('/edit/{permission}', [PermissionController::class,'edit'])->name('edit');
        Route::put('/update/{permission}', [PermissionController::class,'update'])->name('update');
        Route::delete('{permission}/destroy', [PermissionController::class,'destroy'])->name('destroy');

    });

    Route::prefix('professions')->as('professions.')->group(function () {
        Route::get('/', [ProfessionController::class, 'index'])->name('index');
        Route::get('/create', [ProfessionController::class, 'create'])->name('create');
        Route::post('/store', [ProfessionController::class, 'store'])->name('store');
        Route::get('/{profession}/edit', [ProfessionController::class, 'edit'])->name('edit');
        Route::put('/{profession}/update', [ProfessionController::class, 'update'])->name('update');


    });

    Route::prefix('values')->as('values.')->group(function () {
        Route::get('/', [ValueController::class, 'index'])->name('index');
        Route::get('/create', [ValueController::class, 'create'])->name('create');
        Route::get('/{value}/edit', [ValueController::class, 'edit'])->name('edit');
        Route::post('/store', [ValueController::class, 'store'])->name('store');
        Route::put('/{value}/update', [ValueController::class, 'update'])->name('update');

    });

    /** FIX hay dos RoleControllers */
    Route::resource('roles', App\Http\Controllers\Parameters\RoleController::class);

    Route::prefix('communes')->as('communes.')->group(function () {
        Route::get('/', [CommuneController::class,'index'])->name('index');
        Route::put('/{commune}', [CommuneController::class,'update'])->name('update');
    });

    Route::prefix('establishments')->as('establishments.')->group(function () {
        Route::get('/', [EstablishmentController::class,'index'])->name('index');
        Route::put('/{establishment}', [EstablishmentController::class,'update'])->name('update');
    });

    Route::get('/holidays', App\Http\Livewire\Parameters\Holidays::class)->name('holidays');

    Route::prefix('locations')->as('locations.')->group(function () {
        Route::get('/', [LocationController::class,'index'])->name('index');
        Route::get('/create', [LocationController::class,'create'])->name('create');
        Route::get('/edit/{location}', [LocationController::class,'edit'])->name('edit');
        Route::put('/update/{location}', [LocationController::class,'update'])->name('update');
        Route::post('/store', [LocationController::class,'store'])->name('store');
    });

    Route::prefix('places')->as('places.')->group(function () {
        Route::get('/', [PlaceController::class,'index'])->name('index');
        Route::get('/create', [PlaceController::class,'create'])->name('create');
        Route::get('/edit/{place}', [PlaceController::class,'edit'])->name('edit');
        Route::put('/update/{place}', [PlaceController::class,'update'])->name('update');
        Route::post('/store', [PlaceController::class,'store'])->name('store');
    });

    Route::prefix('phrases')->as('phrases.')->group(function () {
        Route::get('/', [PhraseOfTheDayController::class,'index'])->name('index');
        Route::get('/create', [PhraseOfTheDayController::class,'create'])->name('create');
        Route::get('/edit/{phrase}', [PhraseOfTheDayController::class,'edit'])->name('edit');
        Route::put('/update/{phrase}', [PhraseOfTheDayController::class,'update'])->name('update');
        Route::post('/store', [PhraseOfTheDayController::class,'store'])->name('store');
    });

    Route::prefix('measurements')->as('measurements.')->group(function () {
        Route::get('/', [UnitOfMeasurementController::class,'index'])->name('index');
        Route::get('/create', [UnitOfMeasurementController::class,'create'])->name('create');
        Route::get('/edit/{measurement}', [UnitOfMeasurementController::class,'edit'])->name('edit');
        Route::put('/update/{measurement}', [UnitOfMeasurementController::class,'update'])->name('update');
        Route::post('/store', [UnitOfMeasurementController::class,'store'])->name('store');
    });

    Route::prefix('budgetitems')->as('budgetitems.')->group(function () {
        Route::get('/', [BudgetItemController::class,'index'])->name('index');
        Route::get('/create', [BudgetItemController::class,'create'])->name('create');
        Route::get('/edit/{budgetItem}', [BudgetItemController::class,'edit'])->name('edit');
        Route::put('/update/{budgetItem}', [BudgetItemController::class,'update'])->name('update');
        Route::post('/store', [BudgetItemController::class,'store'])->name('store');
    });

    Route::prefix('purchasemechanisms')->as('purchasemechanisms.')->group(function () {
        Route::get('/', [PurchaseMechanismController::class,'index'])->name('index');
        Route::get('/create', [PurchaseMechanismController::class,'create'])->name('create');
        Route::get('/edit/{purchaseMechanism}', [PurchaseMechanismController::class,'edit'])->name('edit');
        Route::put('/update/{purchaseMechanism}', [PurchaseMechanismController::class,'update'])->name('update');
        Route::post('/store', [PurchaseMechanismController::class,'store'])->name('store');
    });

    Route::prefix('purchasetypes')->as('purchasetypes.')->group(function () {
        Route::get('/', [PurchaseTypeController::class,'index'])->name('index');
        Route::get('/create', [PurchaseTypeController::class,'create'])->name('create');
        Route::get('/edit/{purchaseType}', [PurchaseTypeController::class,'edit'])->name('edit');
        Route::put('/update/{purchaseType}', [PurchaseTypeController::class,'update'])->name('update');
        Route::post('/store', [PurchaseTypeController::class,'store'])->name('store');
    });

    Route::prefix('purchaseunits')->as('purchaseunits.')->group(function () {
        Route::get('/', [PurchaseUnitController::class,'index'])->name('index');
        Route::get('/create', [PurchaseUnitController::class,'create'])->name('create');
        Route::get('/edit/{purchaseUnit}', [PurchaseUnitController::class,'edit'])->name('edit');
        Route::put('/update/{purchaseUnit}', [PurchaseUnitController::class,'update'])->name('update');
        Route::post('/store', [PurchaseUnitController::class,'store'])->name('store');
    });

    Route::prefix('suppliers')->as('suppliers.')->group(function () {
        Route::get('/', [App\Http\Controllers\Parameters\SupplierController::class,'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Parameters\SupplierController::class,'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Parameters\SupplierController::class,'store'])->name('store');
        Route::get('/edit/{supplier}', [App\Http\Controllers\Parameters\SupplierController::class,'edit'])->name('edit');
        Route::put('/update/{supplier}', [App\Http\Controllers\Parameters\SupplierController::class,'update'])->name('update');
    });

    Route::prefix('logs')->name('logs.')->middleware('auth')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('index');
        Route::get('{log}', [LogController::class, 'show'])->name('show')->where('id', '[0-9]+');
        // Route::get('{log}/edit', [LogController::class, 'edit'])->name('edit');
        // Route::put('{log}', [LogController::class, 'update'])->name('update');
        Route::get('{log}/destroy', [LogController::class, 'destroy'])->name('destroy');
    });

    Route::resource('programs', ParametersProgramController::class)->only(['index', 'create', 'edit']);
});

Route::prefix('documents')->as('documents.')->middleware('auth')->group(function () {
    Route::post('/create_from_previous', [DocumentController::class,'createFromPrevious'])->name('createFromPrevious');
    Route::get('/{document}/download', [DocumentController::class,'download'])->name('download');
    Route::put('/{document}/store_number', [DocumentController::class,'storeNumber'])->name('store_number');
    Route::delete('/{document}/delete_file', [DocumentController::class,'deleteFile'])->name('delete_file');
    Route::get('/add_number', [DocumentController::class,'addNumber'])->name('add_number');
    Route::post('/find', [DocumentController::class,'find'])->name('find');
    Route::get('/report', [DocumentController::class,'report'])->name('report');
    Route::get('/{document}/sendForSignature/', [DocumentController::class,'sendForSignature'])->name('sendForSignature');
    Route::get('/signed-document-pdf/{id}', [DocumentController::class, 'signedDocumentPdf'])->name('signedDocumentPdf');

    Route::prefix('partes')->as('partes.')->group(function () {
        Route::get('outbox', [ParteController::class,'outbox'])->name('outbox');
        Route::get('/download/{file}',  [ParteController::class,'download'])->name('download');
        Route::delete('/files/{file}', [ParteFileController::class,'destroy'])->name('files.destroy');
        Route::get('/admin', [ParteController::class,'admin'])->name('admin');
        Route::get('/download/{parte}', [ParteController::class,'download'])->name('download');
        Route::get('/view/{parte}', [ParteController::class,'view'])->name('view');
        Route::get('/inbox', [ParteController::class,'inbox'])->name('inbox');
    });
    Route::resource('partes', ParteController::class);

    Route::get('signatures/index/{tab}', [SignatureController::class,'index'])->name('signatures.index');
    Route::get('signatures/create/{xAxis?}/{yAxis?}', [SignatureController::class,'create'])->name('signatures.create');
    Route::resource('signatures', SignatureController::class)->except(['index', 'create']);
    Route::get('/showPdf/{signaturesFile}/{timestamp?}', [SignatureController::class,'showPdf'])->name('signatures.showPdf');
    Route::post('/showPdfFromFile', [SignatureController::class,'showPdfFromFile'])->name('signatures.showPdfFromFile');
    Route::get('/showPdfAnexo/{anexo}', [SignatureController::class,'showPdfAnexo'])->name('signatures.showPdfAnexo');
    Route::post('/{idSignaturesFlow}/rechazar', [SignatureController::class,'rejectSignature'])->name('signatures.rejectSignature');
    Route::get('signatures/signatureFlows/{signatureId}', [SignatureController::class,'signatureFlows'])->name('signatures.signatureFlows');
    Route::get('signatures/signModal/{pendingSignaturesFlowId}', [SignatureController::class,'signModal'])->name('signatures.signModal');
    Route::get('signatures/massSignModal/{pendingSignaturesFlowIds}', [SignatureController::class,'massSignModal'])->name('signatures.massSignModal');
    Route::get('/callback_firma/{message}/{modelId}/{signaturesFile?}', [SignatureController::class,'callbackFirma'])->name('callbackFirma');
});
Route::resource('documents', DocumentController::class)->middleware('auth');

Route::prefix('requirements')->as('requirements.')->middleware('auth')->group(function () {
    /** Custom routes */
    Route::get('download/{file}',  [EventController::class,'download'])->name('download');
    Route::get('outbox', [RequirementController::class,'outbox'])->name('outbox');
    Route::get('secretary_outbox', [RequirementController::class,'secretary_outbox'])->name('secretary_outbox');
    Route::get('archive_requirement/{requirement}', [RequirementController::class,'archive_requirement'])->name('archive_requirement');
    Route::get('archive_requirement_delete/{requirement}', [RequirementController::class,'archive_requirement_delete'])->name('archive_requirement_delete');
    Route::get('asocia_categorias', [RequirementController::class,'asocia_categorias'])->name('asocia_categorias');
    Route::get('create_requirement/{parte}',  [RequirementController::class,'create_requirement'])->name('create_requirement');
    Route::get('create_requirement_sin_parte',  [RequirementController::class,'create_requirement_sin_parte'])->name('create_requirement_sin_parte');
    // Route::get('create_event/{req_id}',  [EventController::class,'create_event'])->name('create_event');
    Route::resource('categories', CategoryController::class);
    Route::resource('events', EventController::class);
    Route::get('report1', [RequirementController::class,'report1'])->name('report1');
    // Route::get('report_reqs_by_org', [RequirementController::class,'report_reqs_by_org])->name('report_reqs_by_org');

    //Route::get('/', [RequirementController::class,'outbox'])->name('index');
    //Route::get('inbox/{user?}', [RequirementController::class,'inbox'])->name('inbox');
    Route::get('/inbox/{user?}', [RequirementController::class,'inbox'])->name('inbox');

    Route::get('/create', [RequirementController::class,'show'])->name('create');
    Route::post('/', [RequirementController::class,'store'])->name('store');
    Route::get('/{requirement}', [RequirementController::class,'show'])->name('show');
    Route::delete('/{requirement}', [RequirementController::class,'destroy'])->name('destroy');
});

Route::view('calendars', 'calendars.index')->name('calendars');

Route::prefix('indicators')->as('indicators.')->group(function () {
    Route::get('/', function () {
        return view('indicators.index');
    })->name('index');

    Route::get('/population', [SingleParameterController::class,'population'])->name('population');
    Route::resource('single_parameter', SingleParameterController::class)->middleware('auth');

    Route::prefix('comges')->as('comges.')->group(function () {
        Route::get('/', [ComgesController::class,'index'])->name('index');
        Route::get('/{year}', [ComgesController::class,'list'])->name('list');
        Route::post('/{year}', [ComgesController::class,'store'])->name('store');
        Route::get('/{year}/create', [ComgesController::class,'create'])->middleware('auth')->name('create');
        Route::get('/{comges}/edit', [ComgesController::class,'edit'])->middleware('auth')->name('edit');
        Route::put('/{comges}', [ComgesController::class,'update'])->middleware('auth')->name('update');
        Route::get('/{year}/{comges}/corte/{section}', [ComgesController::class,'show'])->name('show');
        Route::get('/{year}/{comges}/corte/{section}/ind/{indicator}/create', [ComgesController::class,'createAction'])->middleware('auth')->name('action.create');
        Route::get('/{year}/{comges}/corte/{section}/ind/{indicator}/action/{action}/edit', [ComgesController::class,'editAction'])->middleware('auth')->name('action.edit');
        Route::put('/{year}/{comges}/corte/{section}/ind/{indicator}/action/{action}', [ComgesController::class,'updateAction'])->middleware('auth')->name('action.update');
        Route::post('/{year}/{comges}/corte/{section}/ind/{indicator}', [ComgesController::class,'storeAction'])->middleware('auth')->name('action.store');
    });

    Route::prefix('health_goals')->as('health_goals.')->group(function () {
        Route::get('/show_file/{attachedFile}', [HealthGoalController::class,'show_file'])->name('ind.show_file');
        Route::delete('/{attachedFile}', [HealthGoalController::class,'destroy_file'])->middleware('auth')->name('ind.value.destroy_file');
        Route::get('/{law}', [HealthGoalController::class,'index'])->name('index');
        Route::get('/{law}/{year}', [HealthGoalController::class,'list'])->name('list');
        Route::get('/{law}/{year}/{health_goal}', [HealthGoalController::class,'show'])->name('show');
        Route::get('/{law}/{year}/{health_goal}/ind/{indicator}/edit', [HealthGoalController::class,'editInd'])->middleware('auth')->name('ind.edit');
        Route::put('/{law}/{year}/{health_goal}/ind/{indicator}', [HealthGoalController::class,'updateInd'])->middleware('auth')->name('ind.update');
        Route::post('/{law}/{year}/{health_goal}/ind/{indicator}/import', [HealthGoalController::class,'importIndValues'])->middleware('auth')->name('ind.import');
        Route::post('/{law}/{year}/{health_goal}/ind/{indicator}/saveFile', [HealthGoalController::class,'saveFileInd'])->middleware('auth')->name('ind.saveFile');
        Route::post('/{law}/{year}/{health_goal}/ind/{indicator}/value/{value}', [HealthGoalController::class,'storeIndValue'])->middleware('auth')->name('ind.value.store');
        Route::put('/{law}/{year}/{health_goal}/ind/{indicator}/value/{value}', [HealthGoalController::class,'updateIndValue'])->middleware('auth')->name('ind.value.update');
    });

    Route::prefix('programming_aps')->as('programming_aps.')->group(function () {
        Route::get('/', [ProgramApsController::class,'index'])->name('index');
        Route::get('/{year}/{commune}', [ProgramApsController::class,'show'])->name('show');
    });

    Route::prefix('iaps')->as('iaps.')->group(function () {
        Route::get('/', [ApsController::class,'index'])->name('index');
        Route::get('/{year}', [ApsController::class,'list'])->name('list');
        Route::get('/{year}/{slug}/{establishment_type}', [ApsController::class,'show'])->name('show');
    });

    Route::prefix('iiaaps')->as('iiaaps.')->group(function () {
        Route::get('/', [App\Http\Controllers\Indicators\IaapsController::class,'index'])->name('index');
        Route::get('/{year}', [App\Http\Controllers\Indicators\IaapsController::class,'list'])->name('list');
        Route::get('/{year}/{commune}', [App\Http\Controllers\Indicators\IaapsController::class,'show'])->name('show');
    });

    Route::prefix('19813')->as('19813.')->group(function () {
        Route::get('/', function () {
            return view('indicators.19813.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            //Route::get('', [IndicatorController::class,'index_19813')->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'index'])->name('index');

            Route::get('/indicador1', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador1'])->name('indicador1');
            Route::get('/indicador2', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador2'])->name('indicador2');
            Route::get('/indicador3a', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador3a'])->name('indicador3a');
            Route::get('/indicador3b', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador3b'])->name('indicador3b');
            Route::get('/indicador3c', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador3c'])->name('indicador3c');
            Route::get('/indicador4a', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador4a'])->name('indicador4a');
            Route::get('/indicador4b', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador4b'])->name('indicador4b');
            Route::get('/indicador5', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador5'])->name('indicador5');
            Route::get('/indicador6', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class,'indicador6'])->name('indicador6');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/',           [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'index'])->name('index');
            Route::get('/indicador1', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador1'])->name('indicador1');
            Route::get('/indicador2', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador2'])->name('indicador2');
            Route::get('/indicador3a', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador3a'])->name('indicador3a');
            Route::get('/indicador3b', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador3b'])->name('indicador3b');
            Route::get('/indicador3c', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador3c'])->name('indicador3c');
            Route::get('/indicador4a', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador4a'])->name('indicador4a');
            Route::get('/indicador4b', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador4b'])->name('indicador4b');
            Route::get('/indicador5', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador5'])->name('indicador5');
            Route::get('/indicador6', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class,'indicador6'])->name('indicador6');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/',           [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'index'])->name('index');
            Route::get('/indicador1', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador1'])->name('indicador1');
            Route::get('/indicador2', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador2'])->name('indicador2');
            Route::get('/indicador3a', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador3a'])->name('indicador3a');
            Route::get('/indicador3b', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador3b'])->name('indicador3b');
            Route::get('/indicador3c', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador3c'])->name('indicador3c');
            Route::get('/indicador4a', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador4a'])->name('indicador4a');
            Route::get('/indicador4b', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador4b'])->name('indicador4b');
            Route::get('/indicador5', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador5'])->name('indicador5');
            Route::get('/indicador6', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class,'indicador6'])->name('indicador6');
        });
    });

    Route::prefix('19664')->as('19664.')->group(function () {
        Route::get('/', function () {
            return view('indicators.19664.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class,'index'])->name('index');
            Route::get('/servicio', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class,'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class,'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class,'reyno'])->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class,'index'])->name('index');
            Route::get('/servicio', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class,'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class,'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class,'reyno'])->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class,'index'])->name('index');
            Route::get('/servicio', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class,'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class,'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class,'reyno'])->name('reyno');
        });
    });

    Route::prefix('18834')->as('18834.')->group(function () {
        Route::get('/', function () {
            return view('indicators.18834.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            //Route::get('', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index_18834'])->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index'])->name('index');

            Route::get('/servicio', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'reyno'])->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            //Route::get('', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index_18834'])->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class,'index'])->name('index');

            Route::get('/servicio', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class,'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class,'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class,'reyno'])->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            //Route::get('', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index_18834'])->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class,'index'])->name('index');

            Route::get('/servicio', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class,'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class,'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class,'reyno'])->name('reyno');
        });
    });

    Route::prefix('program_aps')->as('program_aps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.program_aps.index');
        })->name('index');
        Route::prefix('2018')->as('2018.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class,'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class,'create'])->name('create')->middleware('auth');
            Route::post('/', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class,'store'])->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class,'edit'])->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class,'update'])->name('update')->middleware('auth');
        });
        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class,'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class,'create'])->name('create')->middleware('auth');
            Route::post('/', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class,'store'])->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class,'edit'])->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class,'update'])->name('update')->middleware('auth');
        });
        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', function () {
                return redirect()->route('indicators.program_aps.2020.index', 6);
            })->name('index');
            Route::get('/{commune}', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class,'index'])->name('index');
            Route::get('/{commune}/create', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class,'create'])->name('create')->middleware('auth');
            Route::post('/', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class,'store'])->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class,'edit'])->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class,'update'])->name('update')->middleware('auth');
        });
    });

    Route::prefix('aps')->as('aps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.aps.index');
        })->name('index');
        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorAPSController::class,'index'])->name('index');
            Route::get('/pmasama', [App\Http\Controllers\Indicators\_2020\IndicatorAPSController::class,'pmasama'])->name('pmasama');

            Route::prefix('chcc')->as('chcc.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class,'reyno'])->name('reyno');
                Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class,'hospital'])->name('hospital');
            });

            Route::prefix('depsev')->as('depsev.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorDepsevController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorDepsevController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorDepsevController::class,'reyno'])->name('reyno');
            });

            Route::prefix('saserep')->as('saserep.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class,'reyno'])->name('reyno');
                Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class,'hospital'])->name('hospital');
            });

            Route::prefix('ges_odont')->as('ges_odont.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorGesOdontController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorGesOdontController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorGesOdontController::class,'reyno'])->name('reyno');
            });

            Route::prefix('sembrando_sonrisas')->as('sembrando_sonrisas.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorSembrandoSonrisasController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorSembrandoSonrisasController::class,'aps'])->name('aps');
                Route::get('/servicio', [App\Http\Controllers\Indicators\_2020\IndicatorSembrandoSonrisasController::class,'servicio'])->name('servicio');
            });

            Route::prefix('mejoramiento_atencion_odontologica')->as('mejoramiento_atencion_odontologica.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorMejorAtenOdontController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorMejorAtenOdontController::class,'aps'])->name('aps');
            });

            Route::prefix('odontologico_integral')->as('odontologico_integral.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorOdontIntegralController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorOdontIntegralController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorOdontIntegralController::class,'reyno'])->name('reyno');
            });

            Route::prefix('resolutividad')->as('resolutividad.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorResolutividadController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorResolutividadController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorResolutividadController::class,'reyno'])->name('reyno');
            });

            Route::prefix('pespi')->as('pespi.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorPespiController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorPespiController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorPespiController::class,'reyno'])->name('reyno');
            });

            Route::prefix('equidad_rural')->as('equidad_rural.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorEquidadRuralController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorEquidadRuralController::class,'aps'])->name('aps');
                // Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorEquidadRuralController::class,'reyno'])->name('reyno');
            });

            Route::prefix('respiratorio')->as('respiratorio.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorRespiratorioController::class,'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorRespiratorioController::class,'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorRespiratorioController::class,'reyno'])->name('reyno');
            });
        });
    });

    Route::prefix('iaaps')->as('iaaps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.iaaps.index');
        })
        ->name('index');

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\IAAPS\_2019\IAAPSController::class,'index'])
                ->name('index');

            /* Iquique 1101 */
            Route::get('/{comuna}', [App\Http\Controllers\Indicators\IAAPS\_2019\IAAPSController::class,'show'])
                ->name('show');
        });
    });

    Route::prefix('rem')->as('rem.')->group(function () {
        Route::get('/{year}', [App\Http\Controllers\Indicators\RemController::class,'list'])->name('list');
        Route::get('/{year}/{serie}', [App\Http\Controllers\Indicators\RemController::class,'index'])->name('index');
        Route::get('/{year}/{serie}/{nserie}/{unique?}', [App\Http\Controllers\Indicators\RemController::class,'show'])->name('show');
    });

    Route::prefix('rems')->as('rems.')->group(function () {
        Route::get('/', [App\Http\Controllers\Indicators\Rems\RemController::class,'index'])->name('index');
        Route::get('2019', function () {
            return view('indicators.rem.2019.index');
        })->name('2019.index');
        Route::get('2020', function () {
            return view('indicators.rem.2020.index');
        })->name('2020.index');

        Route::get('/{year}/{serie}', [App\Http\Controllers\Indicators\Rems\RemController::class,'index_serie_year'])->name('year.serie.index');

        Route::get('/{year}/{serie}/{nserie}', [App\Http\Controllers\Indicators\Rems\RemController::class,'a01'])->name('year.serie.nserie.index');
        Route::post('/{year}/{serie}/{nserie}', [App\Http\Controllers\Indicators\Rems\RemController::class,'show'])->name('year.serie.nserie.index');
    });
});


/* Middleware 'Drugs' hace que no se pueda tener acceso al módulo de drogas fuera de horario de oficina */
Route::prefix('drugs')->as('drugs.')->middleware('can:Drugs','auth','drugs')->group(function(){
    Route::resource('courts',App\Http\Controllers\Drugs\CourtController::class);
    Route::resource('police_units',App\Http\Controllers\Drugs\PoliceUnitController::class);
    Route::resource('substances',App\Http\Controllers\Drugs\SubstanceController::class);

    Route::get('users',[UserController::class,'drugs'])->name('users');

    Route::get('receptions/report',[App\Http\Controllers\Drugs\ReceptionController::class,'report'])->name('receptions.report');
    Route::get('receptions/{reception}/record',[App\Http\Controllers\Drugs\ReceptionController::class,'showRecord'])->name('receptions.record');
    Route::get('receptions/{receptionitem}/edit_item',[App\Http\Controllers\Drugs\ReceptionController::class,'editItem'])->name('receptions.edit_item');
    Route::put('receptions/{receptionitem}/update_item',[App\Http\Controllers\Drugs\ReceptionController::class,'updateItem'])->name('receptions.update_item');
    Route::delete('receptions/{receptionitem}/destroy_item',[App\Http\Controllers\Drugs\ReceptionController::class,'destroyItem'])->name('receptions.destroy_item');
    Route::put('receptions/{receptionitem}/store_result',[App\Http\Controllers\Drugs\ReceptionController::class,'storeResult'])->name('receptions.store_result');
    Route::put('receptions/{receptionitem}/store_protocol',[App\Http\Controllers\Drugs\ReceptionController::class,'storeProtocol'])->name('receptions.store_protocol');
    Route::get('receptions/protocols/{protocol}',[App\Http\Controllers\Drugs\ReceptionController::class,'showProtocol'])->name('receptions.protocols.show');
    Route::post('receptions/{reception}/item',[App\Http\Controllers\Drugs\ReceptionController::class,'storeItem'])->name('receptions.storeitem');
    Route::get('receptions/{reception}/doc_fiscal',[App\Http\Controllers\Drugs\ReceptionController::class,'showDocFiscal'])->name('receptions.doc_fiscal');
    Route::get('receptions/{reception}/sample_to_isp',[App\Http\Controllers\Drugs\SampleToIspController::class,'show'])->name('receptions.sample_to_isp.show');
    Route::post('receptions/{reception}/sample_to_isp',[App\Http\Controllers\Drugs\SampleToIspController::class,'store'])->name('receptions.sample_to_isp.store');
    Route::get('receptions/{reception}/record_to_court',[App\Http\Controllers\Drugs\RecordToCourtController::class,'show'])->name('receptions.record_to_court.show');
    Route::post('receptions/{reception}/record_to_court',[App\Http\Controllers\Drugs\RecordToCourtController::class,'store'])->name('receptions.record_to_court.store');

    Route::resource('receptions',App\Http\Controllers\Drugs\ReceptionController::class);

    Route::resource('destructions',App\Http\Controllers\Drugs\DestructionController::class)->except(['create']);

    Route::get('rosters/analisis_to_admin',[App\Http\Controllers\Drugs\RosterAnalisisToAdminController::class,'index'])->name('roster.analisis_to_admin.index');
    Route::get('rosters/analisis_to_admin/{id}',[App\Http\Controllers\Drugs\RosterAnalisisToAdminController::class,'show'])->name('roster.analisis_to_admin.show');
});

Route::get('health_plan/{comuna}', [HealthPlanController::class,'index'])->middleware('auth')->name('health_plan.index');
Route::get('health_plan/{comuna}/{file}', [HealthPlanController::class,'download'])->middleware('auth')->name('health_plan.download');

Route::get('quality_aps', [QualityApsController::class,'index'])->middleware('auth')->name('quality_aps.index');
Route::get('quality_aps/{file}', [QualityApsController::class,'download'])->middleware('auth')->name('quality_aps.download');

// UNSPSC
Route::prefix('unspsc')->middleware('auth')->group(function () {

    Route::get('/products/all', [ProductController::class, 'all'])->name('products.all');

    Route::get('/segments', [SegmentController::class, 'index'])->name('segments.index');

    Route::prefix('segment/{segment:code}')->middleware('auth')->group(function () {
        Route::get('/edit', [SegmentController::class, 'edit'])->name('segments.edit');
        Route::get('/families', [FamilyController::class, 'index'])->name('families.index');

        Route::prefix('family/{family:code}')->group(function () {
            Route::get('/edit', [FamilyController::class, 'edit'])->name('families.edit');
            Route::get('/classes', [ClassController::class, 'index'])->name('class.index');

            Route::prefix('class/{class:code}')->group(function () {
                Route::get('/edit', [ClassController::class, 'edit'])->name('class.edit');
                Route::get('/products', [ProductController::class, 'index'])->name('products.index');

                Route::get('/product/{product:code}/edit', [ProductController::class, 'edit'])->name('products.edit');
            });
        });
    });
});

// Warehouse
Route::prefix('warehouse')->as('warehouse.')->middleware('auth')->group(function () {

    Route::resource('stores', StoreController::class)->only(['index', 'create', 'edit'])->middleware(['role:Store: Super admin']);

    Route::prefix('/store')->group(function () {
        Route::get('welcome', [StoreController::class, 'welcome'])->name('store.welcome');

        Route::prefix('{store}')->middleware('ensure.store')->group(function () {
            Route::get('active', [StoreController::class, 'activateStore'])->name('store.active');
            Route::get('users', [StoreController::class, 'users'])->name('stores.users')->middleware('role:Store: Super admin');
            Route::get('report', [StoreController::class, 'report'])->name('store.report');
            Route::get('generate-reception', [ControlController::class, 'generateReception'])->name('generate-reception');

            Route::resource('controls', ControlController::class)->except(['store', 'update', 'show']);
            Route::resource('products', WarehouseProductController::class)->only(['index', 'create', 'edit']);
            Route::resource('categories', WarehouseCategoryController::class)->only(['index', 'create', 'edit']);
            Route::resource('origins', OriginController::class)->only(['index', 'create', 'edit']);
            Route::resource('destinations', DestinationController::class)->only(['index', 'create', 'edit']);
            Route::prefix('control/{control}')->group(function () {
                Route::get('pdf', [ControlController::class, 'pdf'])->name('control.pdf');
                Route::get('add-products', [ControlController::class, 'addProduct'])->name('control.add-product');
            });
        });
    });

});

Route::prefix('inventories')->as('inventories.')->group(function() {
    Route::get('last-income', [InventoryController::class, 'last_income'])->name('last-income');
    Route::get('pending-inventory', [InventoryController::class, 'pending_inventory'])->name('pending-inventory');
    Route::get('/', [InventoryController::class, 'index'])->name('index');
    Route::get('inventory/1/details', [InventoryController::class, 'details'])->name('details');
});

/* Bodega de Farmacia */
Route::prefix('pharmacies')->as('pharmacies.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Pharmacies\PharmacyController::class,'index'])->name('index');
    Route::get('admin_view', [App\Http\Controllers\Pharmacies\PharmacyController::class,'admin_view'])->name('admin_view');
    Route::get('pharmacy_users', [App\Http\Controllers\Pharmacies\PharmacyController::class,'pharmacy_users'])->name('pharmacy_users');
    Route::post('user_asign_store', [PharmacyController::class, 'user_asign_store'])->name('user_asign_store');
    Route::delete('/{pharmacy}/{user}/user_asign_destroy', [PharmacyController::class, 'user_asign_destroy'])->name('user_asign_destroy');


    Route::resource('establishments', App\Http\Controllers\Pharmacies\EstablishmentController::class);
    Route::resource('programs', App\Http\Controllers\Pharmacies\ProgramController::class);
    Route::resource('suppliers', App\Http\Controllers\Pharmacies\SupplierController::class);

    Route::prefix('products')->as('products.')->middleware('auth')->group(function () {
        Route::resource('receiving', App\Http\Controllers\Pharmacies\ReceivingController::class);
        Route::resource('receiving_item', App\Http\Controllers\Pharmacies\ReceivingItemController::class);
        Route::get('receiving/record/{receiving}', [App\Http\Controllers\Pharmacies\ReceivingController::class,'record'])->name('receiving.record');
        Route::get('dispatch/product/due_date/{product_id?}', [App\Http\Controllers\Pharmacies\DispatchController::class,'getFromProduct_due_date'])->name('dispatch.product.due_date')->middleware('auth');
        Route::get('dispatch/product/batch/{product_id?}/{due_date?}', [App\Http\Controllers\Pharmacies\DispatchController::class,'getFromProduct_batch'])->name('dispatch.product.batch')->middleware('auth');
        Route::get('dispatch/product/count/{product_id?}/{due_date?}/{batch?}', [App\Http\Controllers\Pharmacies\DispatchController::class,'getFromProduct_count'])->name('dispatch.product.count')->middleware('auth');
        Route::get('/exportExcel', [App\Http\Controllers\Pharmacies\DispatchController::class,'exportExcel'])->name('exportExcel')->middleware('auth');

        Route::resource('dispatch', App\Http\Controllers\Pharmacies\DispatchController::class);
        Route::resource('dispatch_item', App\Http\Controllers\Pharmacies\DispatchItemController::class);
        Route::get('dispatch/record/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class,'record'])->name('dispatch.record');
        Route::get('dispatch/sendC19/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class,'sendC19'])->name('dispatch.sendC19');
        Route::get('dispatch/deleteC19/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class,'deleteC19'])->name('dispatch.deleteC19');
        Route::post('dispatch/{dispatch}/file', [App\Http\Controllers\Pharmacies\DispatchController::class,'storeFile'])->name('dispatch.storeFile');
        Route::get('dispatch/{dispatch}/file', [App\Http\Controllers\Pharmacies\DispatchController::class,'openFile'])->name('dispatch.openFile');
        Route::resource('purchase', App\Http\Controllers\Pharmacies\PurchaseController::class);
        Route::resource('purchase_item', App\Http\Controllers\Pharmacies\PurchaseItemController::class);
        Route::get('purchase/sendForSignature/{purchase}/', [App\Http\Controllers\Pharmacies\PurchaseController::class,'sendForSignature'])->name('purchase.sendForSignature');
        Route::get('purchase/record/{purchase}', [App\Http\Controllers\Pharmacies\PurchaseController::class,'record'])->name('purchase.record');
        Route::get('purchase/record-pdf/{purchase}', [App\Http\Controllers\Pharmacies\PurchaseController::class,'recordPdf'])->name('purchase.record_pdf');
        Route::get('/callback-firma-record/{message}/{modelId}/{signaturesFile?}', [PurchaseController::class, 'callbackFirmaRecord'])->name('callbackFirmaRecord');
        Route::get('/signed-record-pdf/{purchase}', [PurchaseController::class, 'signedRecordPdf'])->name('signed_record_pdf');

        Route::resource('transfer', App\Http\Controllers\Pharmacies\TransferController::class);
        Route::get('transfer/{establishment}/auth', [App\Http\Controllers\Pharmacies\TransferController::class,'auth'])->name('transfer.auth');
        Route::resource('deliver', App\Http\Controllers\Pharmacies\DeliverController::class);
        Route::put('deliver/{deliver}/confirm', [App\Http\Controllers\Pharmacies\DeliverController::class,'confirm'])->name('deliver.confirm');
        Route::put('deliver/{deliver}/saveDocId', [App\Http\Controllers\Pharmacies\DeliverController::class,'saveDocId'])->name('deliver.saveDocId');
        Route::delete('deliver/{deliver}/restore', [App\Http\Controllers\Pharmacies\DeliverController::class,'restore'])->name('deliver.restore');
    });
    Route::resource('products', App\Http\Controllers\Pharmacies\ProductController::class);

    Route::prefix('reports')->as('reports.')->middleware('auth')->group(function () {
        Route::get('bincard', [App\Http\Controllers\Pharmacies\ProductController::class,'repBincard'])->name('bincard');
        Route::get('purchase_report', [App\Http\Controllers\Pharmacies\ProductController::class,'repPurchases'])->name('purchase_report');
        Route::get('informe_movimientos', [App\Http\Controllers\Pharmacies\ProductController::class,'repInformeMovimientos'])->name('informe_movimientos');
        Route::get('product_last_prices', [App\Http\Controllers\Pharmacies\ProductController::class,'repProductLastPrices'])->name('product_last_prices');
        Route::get('consume_history', [App\Http\Controllers\Pharmacies\ProductController::class,'repConsumeHistory'])->name('consume_history');

        Route::get('products', [App\Http\Controllers\Pharmacies\ProductController::class,'repProduct'])->name('products');
    });
});

/*formulario de requerimiento compra o servicio */
/*
Route::get('request_forms/my_request_inbox', 'RequestForms\RequestFormController::class,'myRequestInbox'])->name('request_forms.my_request_inbox')->middleware('auth');
Route::get('request_forms/authorize_inbox', 'RequestForms\RequestFormController::class,'authorizeInbox'])->name('request_forms.authorize_inbox')->middleware('auth');
Route::get('request_forms/{requestForm}/record', 'RequestForms\RequestFormController::class,'record'])->name('request_forms.record')->middleware('auth');
Route::get('request_forms/finance_inbox', 'RequestForms\RequestFormController::class,'financeInbox'])->name('request_forms.finance_inbox')->middleware('auth');
Route::get('request_forms/director_inbox', 'RequestForms\RequestFormController::class,'directorPassageInbox'])->name('request_forms.director_inbox')->middleware('auth');

Route::put('request_forms/store_approved_request/{request_form}', 'RequestForms\RequestFormController::class,'storeApprovedRequest'])->name('request_forms.store_approved_request')->middleware('auth');
Route::put('request_forms/store_approved_chief/{request_form}', 'RequestForms\RequestFormController::class,'storeApprovedChief'])->name('request_forms.store_approved_chief')->middleware('auth');
Route::put('request_forms/store_finance_data/{request_form}', 'RequestForms\RequestFormController::class,'storeFinanceData'])->name('request_forms.store_finance_data')->middleware('auth');
Route::put('request_forms/add_item_form/{request_form}', 'RequestForms\RequestFormController::class,'addItemForm'])->name('request_forms.add_item_form')->middleware('auth');
Route::put('request_forms/store_approved_finance/{request_form}', 'RequestForms\RequestFormController::class,'storeApprovedFinance'])->name('request_forms.store_approved_finance')->middleware('auth');
Route::put('request_forms/store_reject/{request_form}', 'RequestForms\RequestFormController::class,'storeReject'])->name('request_forms.store_reject')->middleware('auth');
*/
//Route::resource('request_forms', 'RequestForms\RequestFormController::class)->middleware('auth');
/*
Route::prefix('request_forms'])->name('request_forms.')->group(function () {
    Route::get('/', 'RequestForms\RequestFormController::class,'index'])->name('index');
    Route::get('create', 'RequestForms\RequestFormController::class,'create'])->name('create');
    Route::post('store', 'RequestForms\RequestFormController::class,'store'])->name('store');
    Route::get('{request_form}/edit', 'RequestForms\RequestFormController::class,'edit'])->name('edit');
    Route::put('{request_form}/update', 'RequestForms\RequestFormController::class,'update'])->name('update');
    Route::delete('{request_form}/destroy', 'RequestForms\RequestFormController::class,'destroy'])->name('destroy');
});
*/

Route::prefix('request_forms')->as('request_forms.')->middleware('auth')->group(function () {
    Route::get('/my_forms', [RequestFormController::class, 'my_forms'])->name('my_forms');
    Route::get('/all_forms', [RequestFormController::class, 'all_forms'])->name('all_forms');
    Route::get('/pending_forms', [RequestFormController::class, 'pending_forms'])->name('pending_forms');
    Route::get('/contract_manager_forms', [RequestFormController::class, 'contract_manager_forms'])->name('contract_manager_forms');
    Route::get('/create', [RequestFormController::class, 'create'])->name('create');
    Route::get('/{requestForm}/create_provision', [RequestFormController::class, 'create_provision'])->name('create_provision');
    Route::get('/{requestForm}/sign/{eventType}', [RequestFormController::class, 'sign'])->name('sign');
    Route::get('/callback-sign-request-form/{message}/{modelId}/{signaturesFile?}', [RequestFormController::class, 'callbackSign'])->name('callbackSign');
    Route::get('/callback-sign-new-budget/{message}/{modelId}/{signaturesFile?}', [RequestFormController::class, 'callbackSignNewBudget'])->name('callbackSignNewBudget');
    Route::get('/signed-request-form-pdf/{requestForm}/{original}', [RequestFormController::class, 'signedRequestFormPDF'])->name('signedRequestFormPDF');
    Route::get('/request_form_comments', [RequestFormController::class, 'request_form_comments'])->name('request_form_comments');

    Route::prefix('message')->as('message.')->middleware('auth')->group(function () {
        Route::post('/{requestForm}/store/{eventType}/{from}', [RequestFormMessageController::class, 'store'])->name('store');
        Route::get('/show_file/{requestFormMessage}', [RequestFormMessageController::class, 'show_file'])->name('show_file');
    });

    Route::prefix('items')->as('items.')->middleware('auth')->group(function () {
        Route::get('/create', [RequestFormController::class, 'create'])->name('create');
        Route::get('/edit/{itemRequestForm}', [ItemRequestFormController::class, 'edit'])->name('edit');
        Route::post('/update/{itemRequestForm}', [ItemRequestFormController::class, 'update'])->name('update');
    });

    Route::prefix('passengers')->as('passengers.')->middleware('auth')->group(function () {
        Route::get('/create', [RequestFormController::class, 'create'])->name('create');
    });

    Route::prefix('supply')->as('supply.')->middleware('auth')->group(function () {
        Route::get('/', [PurchasingProcessController::class, 'index'])->name('index');
        Route::get('/{requestForm}', [PurchasingProcessController::class, 'show'])->name('show');
        Route::get('/{requestForm}/purchase', [PurchasingProcessController::class, 'purchase'])->name('purchase');
        Route::get('/{requestForm}/purchase/{purchasingProcessDetail}/edit', [PurchasingProcessController::class, 'edit'])->name('edit');
        Route::post('/{requestForm}/create_internal_oc', [PurchasingProcessController::class, 'create_internal_oc'])->name('create_internal_oc');
        Route::post('/{requestForm}/create_petty_cash', [PurchasingProcessController::class, 'create_petty_cash'])->name('create_petty_cash');
        Route::post('/{requestForm}/create_fund_to_be_settled', [PurchasingProcessController::class, 'create_fund_to_be_settled'])->name('create_fund_to_be_settled');
        Route::post('/{requestForm}/create_tender', [PurchasingProcessController::class, 'create_tender'])->name('create_tender');
        Route::post('/{requestForm}/create_oc', [PurchasingProcessController::class, 'create_oc'])->name('create_oc');
        Route::post('/{requestForm}/create_convenio_marco', [PurchasingProcessController::class, 'create_convenio_marco'])->name('create_convenio_marco');
        Route::post('/{requestForm}/create_direct_deal', [PurchasingProcessController::class, 'create_direct_deal'])->name('create_direct_deal');
        Route::put('/{requestForm}/{directDeal}/update_direct_deal', [PurchasingProcessController::class, 'update_direct_deal'])->name('update_direct_deal');
        Route::post('{requestForm}/create_new_budget', [RequestFormController::class, 'create_new_budget'])->name('create_new_budget');
        Route::post('{requestForm}/close_purchasing_process', [PurchasingProcessController::class, 'close_purchasing_process'])->name('close_purchasing_process');
        Route::post('{requestForm}/reasign_purchaser', [PurchasingProcessController::class, 'reasign_purchaser'])->name('reasign_purchaser');
        Route::post('{requestForm}/edit_observation', [PurchasingProcessController::class, 'edit_observation'])->name('edit_observation');
        Route::get('/petty_cash/{pettyCash}/download', [PettyCashController::class, 'download'])->name('petty_cash.download');
        Route::get('/fund_to_be_settled/{fundToBeSettled}/download', [FundToBeSettledController::class, 'download'])->name('fund_to_be_settled.download');
        Route::get('/attached_file/{attachedFile}/download', [AttachedFilesController::class, 'download'])->name('attached_file.download');
        Route::post('/{requestForm}/create_tender', [PurchasingProcessController::class, 'create_tender'])->name('create_tender');
        Route::get('/mercado-publico-api/{type}/{code}', function($type, $code){
            if($type == 'licitaciones') return MercadoPublico::getTender($code);
            elseif($type == 'ordenesdecompra') return MercadoPublico::getPurchaseOrder($code);
            else return null;
        });
    });

    /* DOCUMENTS */
    Route::get('/create_form_document/{requestForm}/{has_increased_expense}', [RequestFormController::class, 'create_form_document'])->name('create_form_document');
    Route::get('/create_view_document/{requestForm}/{has_increased_expense}', [RequestFormController::class, 'create_view_document'])->name('create_view_document');
    Route::get('/create_internal_purchase_order_document/{purchasingProcessDetail}', [InternalPurchaseOrderController::class, 'create_internal_purchase_order_document'])->name('create_internal_purchase_order_document');

    Route::get('/{requestForm}/edit', [RequestFormController::class, 'edit'])->name('edit');

    Route::get('/leadership_index', [RequestFormController::class, 'leadershipIndex'])->name('leadership_index');
    Route::get('/{requestForm}/leadership_sign', [RequestFormController::class, 'leadershipSign'])->name('leadership_sign');

    Route::get('/download/{requestFormFile}', [RequestFormFileController::class, 'download'])->name('download');
    Route::get('/show_file/{requestFormFile}', [RequestFormFileController::class, 'show_file'])->name('show_file');

    Route::get('/show_item_file/{itemRequestForm}', [ItemRequestFormController::class, 'show_item_file'])->name('show_item_file');



    Route::get('/finance_index', [RequestFormController::class, 'financeIndex'])->name('finance_index');
    Route::get('/{requestForm}/finance_sign', [RequestFormController::class, 'financeSign'])->name('finance_sign');

    Route::get('/prefinance_index', [RequestFormController::class, 'prefinanceIndex'])->name('prefinance_index');
    Route::get('/{requestForm}/prefinance_sign', [RequestFormController::class, 'prefinanceSign'])->name('prefinance_sign');

    Route::get('/supply_index', [RequestFormController::class, 'supplyIndex'])->name('supply_index');
    Route::get('/{requestForm}/supply_sign', [RequestFormController::class, 'supplySign'])->name('supply_sign');

    Route::get('/supervisor_user_index', [RequestFormController::class, 'supervisorUserIndex'])->name('supervisor_user_index');
    Route::get('/{requestForm}/purchasing_process', [RequestFormController::class, 'purchasingProcess'])->name('purchasing_process');

    Route::get('/{requestForm}/destroy', [RequestFormController::class, 'destroy'])->name('destroy');
    Route::get('/{requestForm}/show', [RequestFormController::class, 'show'])->name('show');

    Route::post('/store', [RequestFormController::class, 'store'])->name('store');
    Route::put('/update', [RequestFormController::class, 'update'])->name('update');
    Route::get('/my_request_inbox', [RequestFormController::class, 'myRequestInbox'])->name('my_request_inbox');
    //Route::get('/authorize_inbox', [RequestFormController::class, 'authorizeInbox'])->name('authorize_inbox');

    Route::get('/event_show_file/{eventRequestFormFile}', [EventRequestFormFileController::class, 'showFile'])->name('event.show_file');

    //Route::get('/finance_inbox', [RequestFormController::class, 'financeInbox'])->name('finance_inbox');
    //Route::get('/tesseract', [RequestFormController::class, 'financeIndex'])->name('tesseract');
    Route::get('/saludo/{name}/{nickname?}', function ($name, $nickname = null) {
      if ($nickname) {
          return "Bienvenido {$name}, tu apodo es {$nickname}";
        } else {
            return "Bienvenido {$name}, no tienes apodo";
          }
    });

    Route::get('/tesseract', function() {
        return File::get(public_path() . '\tesseract.html');
    });

    //return File::get(public_path() . '/to new folder name/index.html');

    //Route::get('/own', [RequestFormController::class, 'indexOwn'])->name('own');
    //Route::get('/validaterequest', [RequestFormController::class, 'validaterequest'])->name('validaterequest');


    // Route::prefix('passengers')->as('passengers.')->middleware('auth')->group(function () {
    //     Route::get('/', [PassengerController::class, 'index'])->name('index');
    //     Route::get('/create', [PassengerController::class, 'create'])->name('create');
    //     //Route::get('/create', [CategoriesController::class, 'create'])->name('create');
    //     //Route::post('/store', [CategoriesController::class, 'store'])->name('store');
    // });
});

Route::get('/yomevacuno',[VaccinationController::class,'welcome']);

Route::prefix('vaccination')->as('vaccination.')->group(function () {
    Route::get('/welcome',[VaccinationController::class,'welcome'])->name('welcome');
    Route::get('/login/{access_token}',[VaccinationController::class,'login'])->name('login');
    Route::get('/',[VaccinationController::class,'index'])->name('index')->middleware('auth');
    Route::get('/create',[VaccinationController::class,'create'])->name('create')->middleware('auth');
    Route::post('/',[VaccinationController::class,'store'])->name('store')->middleware('auth');
    Route::post('/show',[VaccinationController::class,'show'])->name('show');
    Route::get('/{vaccination}/edit',[VaccinationController::class,'edit'])->name('edit')->middleware('auth');
    Route::put('/{vaccination}',[VaccinationController::class,'update'])->name('update')->middleware('auth');
    Route::get('/report',[VaccinationController::class,'report'])->name('report')->middleware('auth');
    Route::get('/export',[VaccinationController::class,'export'])->name('export')->middleware('auth');
    Route::put('/vaccinate/{vaccination}/{dose}',[VaccinationController::class,'vaccinate'])->name('vaccinate')->middleware('auth');
    Route::get('/vaccinate/remove-booking/{vaccination}',[VaccinationController::class,'removeBooking'])->name('removeBooking')->middleware('auth');
    Route::get('/card/{vaccination}',[VaccinationController::class,'card'])->name('card')->middleware('auth');
    Route::get('/slots',[VaccinationController::class,'slots'])->name('slots')->middleware('auth');
    Route::put('/arrival/{vaccination}/{reverse?}',[VaccinationController::class,'arrival'])->name('arrival')->middleware('auth');
    Route::put('/dome/{vaccination}/{reverse?}',[VaccinationController::class,'dome'])->name('dome')->middleware('auth');
});

Route::prefix('mammography')->as('mammography.')->group(function () {
    Route::get('/welcome',[MammographyController::class,'welcome'])->name('welcome');
    Route::get('/login/{access_token}',[MammographyController::class,'login'])->name('login');
    Route::get('/',[MammographyController::class,'index'])->name('index')->middleware('auth');
    Route::get('/schedule',[MammographyController::class,'schedule'])->name('schedule')->middleware('auth');
    Route::get('/create',[MammographyController::class,'create'])->name('create')->middleware('auth');
    Route::post('/',[MammographyController::class,'store'])->name('store')->middleware('auth');
    Route::post('/show',[MammographyController::class,'show'])->name('show');
    Route::get('/{mammography}/edit',[MammographyController::class,'edit'])->name('edit')->middleware('auth');
    Route::put('/{mammography}',[MammographyController::class,'update'])->name('update')->middleware('auth');
    // Route::get('/report',[VaccinationController::class,'report'])->name('report')->middleware('auth');
    Route::get('/export',[MammographyController::class,'export'])->name('export')->middleware('auth');
    // Route::put('/vaccinate/{vaccination}/{dose}',[VaccinationController::class,'vaccinate'])->name('vaccinate')->middleware('auth');
    // Route::get('/vaccinate/remove-booking/{vaccination}',[VaccinationController::class,'removeBooking'])->name('removeBooking')->middleware('auth');
    // Route::get('/card/{vaccination}',[VaccinationController::class,'card'])->name('card')->middleware('auth');
    Route::get('/slots',[MammographyController::class,'slots'])->name('slots')->middleware('auth');
    // Route::put('/arrival/{vaccination}/{reverse?}',[VaccinationController::class,'arrival'])->name('arrival')->middleware('auth');
    // Route::put('/dome/{vaccination}/{reverse?}',[VaccinationController::class,'dome'])->name('dome')->middleware('auth');
});

Route::prefix('invoice')->as('invoice.')->group(function () {
    Route::get('/welcome',[InvoiceController::class,'welcome'])->name('welcome');
    Route::get('/login/{access_token}',[InvoiceController::class,'login'])->name('login');
    Route::post('/show',[InvoiceController::class,'show'])->name('show');

});



/* Nuevas rutas, Laravel 8.0. */
Route::prefix('suitability')->as('suitability.')->middleware('auth')->group(function () {
    Route::get('/', [SuitabilityController::class, 'indexOwn'])->name('own');
    Route::get('/report', [SuitabilityController::class, 'report'])->name('report');
    Route::delete('{psirequest}/destroy', [SuitabilityController::class, 'destroy'])->name('destroy');
    Route::put('{psirequest}/update', [SuitabilityController::class, 'update'])->name('update');
    Route::post('/', [SuitabilityController::class, 'store'])->name('store');
    Route::get('/own', [SuitabilityController::class, 'indexOwn'])->name('own');
    Route::get('/validaterequest', [SuitabilityController::class, 'validaterequest'])->name('validaterequest');
    Route::post('/validaterun', [SuitabilityController::class, 'validaterun'])->name('validaterun');
    Route::get('/create/{run?}', [SuitabilityController::class, 'create'])->name('create');
    Route::get('/welcome', [TestsController::class, 'welcome'])->name('welcome');
    Route::get('/test/{psi_request_id?}', [TestsController::class, 'index'])->name('test');
    Route::post('/test', [TestsController::class, 'store'])->name('test.store');
    Route::get('/pending', [SuitabilityController::class, 'pending'])->name('pending');
    Route::get('/config-signature', [SuitabilityController::class, 'configSignature'])->name('configSignature');
    Route::post('/config-signature-add', [SuitabilityController::class, 'configSignatureAdd'])->name('configSignatureAdd');
    Route::get('/config-signature-delete/{signer}', [SuitabilityController::class, 'configSignatureDelete'])->name('configSignatureDelete');
    Route::get('/approved', [SuitabilityController::class, 'approved'])->name('approved');
    Route::get('/rejected', [SuitabilityController::class, 'rejected'])->name('rejected');
    Route::patch('/finalresult/{psirequest}/{result}', [SuitabilityController::class, 'finalresult'])->name('finalresult');
    Route::get('/sendForSignature/{id}', [SuitabilityController::class, 'sendForSignature'])->name('sendForSignature');

    Route::prefix('categories')->as('categories.')->middleware('auth')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/store', [CategoriesController::class, 'store'])->name('store');

    });

    Route::prefix('questions')->as('questions.')->middleware('auth')->group(function () {
        Route::get('/', [QuestionsController::class, 'index'])->name('index');
        Route::get('/create', [QuestionsController::class, 'create'])->name('create');
        Route::post('/store', [QuestionsController::class, 'store'])->name('store');
        Route::get('{question}/edit', [QuestionsController::class, 'edit'])->name('edit');
        Route::put('{question}/update', [QuestionsController::class, 'update'])->name('update');
    });

    Route::prefix('options')->as('options.')->middleware('auth')->group(function () {
        Route::get('/', [OptionsController::class, 'index'])->name('index');
        Route::get('/create', [OptionsController::class, 'create'])->name('create');
        Route::post('/store', [OptionsController::class, 'store'])->name('store');
        Route::get('{option}/edit', [OptionsController::class, 'edit'])->name('edit');
        Route::put('{option}/update', [OptionsController::class, 'update'])->name('update');
    });

    Route::prefix('schools')->as('schools.')->middleware('auth')->group(function () {
        Route::get('/', [SchoolsController::class, 'index'])->name('index');
        Route::get('/create', [SchoolsController::class, 'create'])->name('create');
        Route::post('/store', [SchoolsController::class, 'store'])->name('store');
        Route::get('{school}/edit', [SchoolsController::class, 'edit'])->name('edit');
        Route::put('{school}/update', [SchoolsController::class, 'update'])->name('update');
        Route::delete('/{school}/destroy', [SchoolsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->as('users.')->middleware('auth')->group(function () {
        Route::get('/', [SchoolUserController::class, 'index'])->name('index');
        Route::get('/create', [SchoolUserController::class, 'create'])->name('create');
        Route::post('/store', [SchoolUserController::class, 'store'])->name('store');
        Route::delete('/{schooluser}/destroy', [SchoolUserController::class, 'destroy'])->name('destroy');
        Route::post('/storeuser', [SchoolUserController::class, 'storeuser'])->name('storeuser');
    });


    Route::prefix('users')->as('users.')->middleware('auth')->group(function () {
        Route::get('/', [SchoolUserController::class, 'index'])->name('index');
        Route::get('/create', [SchoolUserController::class, 'create'])->name('create');
        Route::post('/store', [SchoolUserController::class, 'store'])->name('store');
    });


    Route::prefix('results')->as('results.')->middleware('auth')->group(function () {
        Route::get('/', [ResultsController::class, 'index'])->name('index');
        Route::delete('{result}/destroy', [ResultsController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [ResultsController::class, 'show'])->name('show');
        Route::get('/certificate/{id}', [ResultsController::class, 'certificate'])->name('certificate');
        Route::get('/certificatepdf/{id}', [ResultsController::class, 'certificatepdf'])->name('certificatepdf');
        Route::get('/signed-suitability-certificate-pdf/{id}', [SuitabilityController::class, 'signedSuitabilityCertificatePDF'])->name('signedSuitabilityCertificate');
        //Route::get('results/{result_id}', 'ResultsController::class,'show'])->name('results.show');
        // Route::get('/create', [OptionsController::class, 'create'])->name('create');
        // Route::post('/store', [OptionsController::class, 'store'])->name('store');
    });

    Route::post('/livewire/message/rrhh.change-shift-day-status', [\App\Http\Livewire\Rrhh\ChangeShiftDayStatus::class]);
    Route::post('/livewire/message/rrhh/change-shift-day-status', [\App\Http\Livewire\Rrhh\ChangeShiftDayStatus::class]);
    // Route::post('livewire/message/rrhh.change-shift-day-status', [\App\Livewire\Rrhh\ChangeShiftDayStatus::class]);+



});





Route::view('/some', 'some');

Route::get('/test-getip',[TestController::class,'getIp']);
Route::get('/log',[TestController::class,'log']);
Route::get('/ous',[TestController::class,'ous']);
Route::get('/test-mercado-publico-api/{date}', [TestController::class, 'getMercadoPublicoTender']);
