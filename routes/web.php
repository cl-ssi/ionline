<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/** ¿Un modelo? */

use App\User;
use App\Models\WebService\MercadoPublico;
use App\Models\Pharmacies\Purchase;


use App\Http\Livewire\Welfare\Amipass\ReportByDates;
use App\Http\Livewire\Welfare\Amipass\RequestMgr;
use App\Http\Livewire\Welfare\Amipass\NewBeneficiaryRequest;
use App\Http\Livewire\Warehouse\Invoices\InvoiceManagement;
use App\Http\Livewire\TicResources;
use App\Http\Livewire\Summary\Template\ShowTemplate;
use App\Http\Livewire\Sign\SignatureIndex;
use App\Http\Livewire\Sign\RequestSignature;
use App\Http\Livewire\Rrhh\NoAttendanceRecordMgr;
use App\Http\Livewire\Rrhh\NoAttendanceRecordIndex;
use App\Http\Livewire\Rrhh\NoAttendanceRecordConfirmation;
use App\Http\Livewire\Rrhh\Attendance\ReasonMgr;
use App\Http\Livewire\Resources\ComputerFusion;
use App\Http\Livewire\Resources\ComputerCreate;
use App\Http\Livewire\Requirements\Categories;
use App\Http\Livewire\RequestForm\ReportGlobalBudget;
use App\Http\Livewire\Profile\Subrogations;
use App\Http\Livewire\Profile\MailSignature;
use App\Http\Livewire\Parameters\Program\BudgetMgr;
use App\Http\Livewire\Parameters\Parameter\ParameterIndex;
use App\Http\Livewire\Parameters\Parameter\ParameterEdit;
use App\Http\Livewire\Parameters\Parameter\ParameterCreate;
use App\Http\Livewire\Parameters\MaintainerPlaces;
use App\Http\Livewire\Lobby\MeetingShow;
use App\Http\Livewire\Lobby\MeetingMgr;
use App\Http\Livewire\Inventory\RegisterInventory;
use App\Http\Livewire\Inventory\PendingMovements;
use App\Http\Livewire\Inventory\MaintainerPlaces as InventoryMaintainerPlaces;
use App\Http\Livewire\Inventory\InventoryUploadExcel;
use App\Http\Livewire\Inventory\InventoryShow;
use App\Http\Livewire\Inventory\InventoryPending;
use App\Http\Livewire\Inventory\InventoryManager;
use App\Http\Livewire\Inventory\InventoryManageUsers;
use App\Http\Livewire\Inventory\InventoryLastReceptions;
use App\Http\Livewire\Inventory\InventoryIndex;
use App\Http\Livewire\Inventory\InventoryEdit;
use App\Http\Livewire\Inventory\CreateTransfer;
use App\Http\Livewire\Inventory\CheckTransfer;
use App\Http\Livewire\Inventory\AssignedProducts;
use App\Http\Livewire\InventoryLabel\InventoryLabelIndex;
use App\Http\Livewire\His\NewModification;
use App\Http\Livewire\His\ModificationMgr;
use App\Http\Livewire\His\ModificationRequestIndex;
use App\Http\Controllers\His\ModificationRequestController;
use App\Http\Livewire\Finance\UploadDtes;
use App\Http\Livewire\Finance\IndexDtes;
use App\Http\Livewire\Finance\DteConfirmation;
use App\Http\Livewire\Documents\ApprovalsMgr;
use App\Http\Controllers\Welfare\WelfareController;
use App\Http\Controllers\Welfare\LoanController;
use App\Http\Controllers\Welfare\AmipassController;
use App\Http\Controllers\WebserviceController;
use App\Http\Controllers\Warehouse\StoreController;
use App\Http\Controllers\Warehouse\ProductController as WarehouseProductController;
use App\Http\Controllers\Warehouse\OriginController;
use App\Http\Controllers\Warehouse\DestinationController;
use App\Http\Controllers\Warehouse\ControlController;
use App\Http\Controllers\Warehouse\CategoryController as WarehouseCategoryController;
//todas las visaciones para confirma y visto bueno de proceso de inventario-finanza-fr
use App\Http\Controllers\Warehouse\VisationContractManager;

use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\Unspsc\SegmentController;
use App\Http\Controllers\Unspsc\ProductController;
use App\Http\Controllers\Unspsc\FamilyController;
use App\Http\Controllers\Unspsc\ClassController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Summary\TemplateController as SummaryTemplateController;
use App\Http\Controllers\Summary\SummaryFileController;
use App\Http\Controllers\Summary\SummaryController;
use App\Http\Controllers\Summary\LinkController;
use App\Http\Controllers\Summary\EventTypeController as SummaryEventTypeController;
use App\Http\Controllers\Summary\EventController as SummaryEventController;
use App\Http\Controllers\Suitability\TestsController;
use App\Http\Controllers\Suitability\SuitabilityController;
use App\Http\Controllers\Suitability\SchoolsController;
use App\Http\Controllers\Suitability\SchoolUserController;
use App\Http\Controllers\Suitability\ResultsController;
use App\Http\Controllers\Suitability\QuestionsController;
use App\Http\Controllers\Suitability\OptionsController;
use App\Http\Controllers\Suitability\CategoriesController;
use App\Http\Controllers\ServiceRequests\ValueController;
use App\Http\Controllers\ServiceRequests\SignatureFlowController;
use App\Http\Controllers\ServiceRequests\ServiceRequestController;
use App\Http\Controllers\ServiceRequests\ReportController;
use App\Http\Controllers\ServiceRequests\ProfileController as ProfileControllerSr;
use App\Http\Controllers\ServiceRequests\InvoiceController;
use App\Http\Controllers\ServiceRequests\FulfillmentItemController;
use App\Http\Controllers\ServiceRequests\FulfillmentController;
use App\Http\Controllers\ServiceRequests\DenominationFormulaController;
use App\Http\Controllers\ServiceRequests\Denomination1121Controller;
use App\Http\Controllers\ServiceRequests\AttachmentController;
use App\Http\Controllers\Rrhh\UserController;
use App\Http\Controllers\Rrhh\SubrogationController;
use App\Http\Controllers\Rrhh\RoleController;
use App\Http\Controllers\Rrhh\OrganizationalUnitController;
use App\Http\Controllers\Rrhh\AuthorityController;
use App\Http\Controllers\Rrhh\AttendanceController;
use App\Http\Controllers\Rrhh\NoAttendanceRecordController;
use App\Http\Controllers\Rrhh\AbsenteeismTypeController;
use App\Http\Controllers\Resources\WingleController;
use App\Http\Controllers\Resources\TelephoneController;
use App\Http\Controllers\Resources\PrinterController;
use App\Http\Controllers\Resources\MobileController;
use App\Http\Controllers\Resources\ComputerController;
use App\Http\Controllers\Requirements\RequirementController;
use App\Http\Controllers\Requirements\LabelController;
use App\Http\Controllers\Requirements\EventController;
use App\Http\Controllers\Requirements\CategoryController;
use App\Http\Controllers\RequestForms\RequestFormMessageController;
use App\Http\Controllers\RequestForms\RequestFormFileController;
use App\Http\Controllers\RequestForms\RequestFormEventController;
use App\Http\Controllers\RequestForms\RequestFormController;
use App\Http\Controllers\RequestForms\RequestFormCodeController;
use App\Http\Controllers\RequestForms\PurchasingProcessController;
use App\Http\Controllers\RequestForms\PettyCashController;
use App\Http\Controllers\RequestForms\PassengerController;
use App\Http\Controllers\RequestForms\ItemRequestFormController;
use App\Http\Controllers\RequestForms\InternalPurchaseOrderController;
use App\Http\Controllers\RequestForms\FundToBeSettledController;
use App\Http\Controllers\RequestForms\EventRequestFormFileController;
use App\Http\Controllers\RequestForms\AttachedFilesController;
use App\Http\Controllers\ReplacementStaff\TrainingController;
use App\Http\Controllers\ReplacementStaff\TechnicalEvaluationFileController;
use App\Http\Controllers\ReplacementStaff\TechnicalEvaluationController;
use App\Http\Controllers\ReplacementStaff\StaffManageController;
use App\Http\Controllers\ReplacementStaff\SelectedPositionController;
use App\Http\Controllers\ReplacementStaff\RequestSignController;
use App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController;
use App\Http\Controllers\ReplacementStaff\ReplacementStaffController;
use App\Http\Controllers\ReplacementStaff\ProfileController;
use App\Http\Controllers\ReplacementStaff\Manage\RstFundamentManageController;
use App\Http\Controllers\ReplacementStaff\Manage\ProfileManageController;
use App\Http\Controllers\ReplacementStaff\Manage\ProfessionManageController;
use App\Http\Controllers\ReplacementStaff\Manage\LegalQualityManageController;
use App\Http\Controllers\ReplacementStaff\LanguageController;
use App\Http\Controllers\ReplacementStaff\ExperienceController;
use App\Http\Controllers\ReplacementStaff\ContactRecordController;
use App\Http\Controllers\ReplacementStaff\CommissionController;
use App\Http\Controllers\ReplacementStaff\ApplicantController;
use App\Http\Controllers\Rem\UserRemController;
use App\Http\Controllers\Rem\RemSerieController;
use App\Http\Controllers\Rem\RemPeriodSerieController;
use App\Http\Controllers\Rem\RemPeriodController;
use App\Http\Controllers\Rem\RemFileController;
use App\Http\Controllers\RNIdb\RNIdbController;
use App\Http\Controllers\QualityAps\QualityApsController;
use App\Http\Controllers\Programmings\TrainingsItemController;
use App\Http\Controllers\Programmings\TaskReschedulingController;
use App\Http\Controllers\Programmings\TaskController;
use App\Http\Controllers\Programmings\ReviewItemController;
use App\Http\Controllers\Programmings\ProgrammingReviewController;
use App\Http\Controllers\Programmings\ProgrammingReportController;
use App\Http\Controllers\Programmings\ProgrammingItemController;
use App\Http\Controllers\Programmings\ProgrammingDayController;
use App\Http\Controllers\Programmings\ProgrammingController;
use App\Http\Controllers\Programmings\ProgrammingActivityItemController;
use App\Http\Controllers\Programmings\ProfessionalHourController;
use App\Http\Controllers\Programmings\ProfessionalController;
use App\Http\Controllers\Programmings\ParticipationController;
use App\Http\Controllers\Programmings\MinisterialProgramController;
//use App\Http\Controllers\RequestForms\SupplyPurchaseController;
use App\Http\Controllers\Programmings\EmergenciesController;
use App\Http\Controllers\Programmings\CommuneFileController;
use App\Http\Controllers\Programmings\ActivitiesProgramController;
use App\Http\Controllers\Programmings\ActivitiesItemController;
use App\Http\Controllers\Programmings\ActionTypeController;
use App\Http\Controllers\Pharmacies\PurchaseController;
use App\Http\Controllers\Pharmacies\PharmacyController;
use App\Http\Controllers\Parameters\UnitOfMeasurementController;
use App\Http\Controllers\Parameters\PurchaseUnitController;
use App\Http\Controllers\Parameters\PurchaseTypeController;
use App\Http\Controllers\Parameters\PurchaseMechanismController;
use App\Http\Controllers\Parameters\ProgramController as ParametersProgramController;
use App\Http\Controllers\Parameters\ProfessionController;
use App\Http\Controllers\Parameters\PhraseOfTheDayController;
use App\Http\Controllers\Parameters\PermissionController;
use App\Http\Controllers\Parameters\ParameterController;
use App\Http\Controllers\Parameters\LogController;
use App\Http\Controllers\Parameters\LocationController;
use App\Http\Controllers\Parameters\InventoryLabelController;
use App\Http\Controllers\Parameters\EstablishmentTypeController;
use App\Http\Controllers\Parameters\EstablishmentController;
use App\Http\Controllers\Parameters\CommuneController;
use App\Http\Controllers\Parameters\BudgetItemController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\Mammography\MammographyController;
use App\Http\Controllers\Lobby\MeetingController;
use App\Http\Controllers\JobPositionProfiles\MessageController;
use App\Http\Controllers\JobPositionProfiles\JobPositionProfileSignController;
use App\Http\Controllers\JobPositionProfiles\JobPositionProfileController;
use App\Http\Controllers\Indicators\SingleParameterController;
use App\Http\Controllers\Indicators\ProgramApsController;
use App\Http\Controllers\Indicators\IaapsController;
use App\Http\Controllers\Indicators\HealthGoalController;
use App\Http\Controllers\Indicators\ComgesController;
use App\Http\Controllers\Indicators\ApsController;
use App\Http\Controllers\HotelBooking\ServiceController;
use App\Http\Controllers\HotelBooking\RoomController;
use App\Http\Controllers\HotelBooking\RoomBookingConfigurationController;
use App\Http\Controllers\HotelBooking\HotelController;
use App\Http\Controllers\HotelBooking\HotelBookingController;
use App\Http\Controllers\ProfAgenda\ProposalController;
use App\Http\Controllers\ProfAgenda\AgendaController;
use App\Http\Controllers\ProfAgenda\OpenHourController;
use App\Http\Controllers\ProfAgenda\ActivityTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HealthPlan\HealthPlanController;
use App\Http\Controllers\Finance\PurchaseOrderController;
use App\Http\Controllers\Finance\PaymentController;
use App\Http\Controllers\Finance\DteController;
use App\Http\Controllers\Drugs\SubstanceController;
use App\Http\Controllers\Drugs\RosterAnalisisToAdminController;
use App\Http\Controllers\Drugs\ReceptionController;
use App\Http\Controllers\Drugs\CourtController;
use App\Http\Controllers\Drugs\ActPrecursorController;
use App\Http\Controllers\Documents\SignatureController;
use App\Http\Controllers\Documents\Sign\SignatureController as SignSignatureController;
use App\Http\Controllers\Documents\ParteFileController;
use App\Http\Controllers\Documents\ParteController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\DigitalSignatureController;
use App\Http\Controllers\ClaveUnicaController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AssigmentController;
use App\Http\Controllers\Allowances\AllowanceSignController;
use App\Http\Controllers\Allowances\AllowanceFileController;
use App\Http\Controllers\Allowances\AllowanceController;
use App\Http\Controllers\Agreements\WordWithdrawalAgreeController;
use App\Http\Controllers\Agreements\WordTestController;
use App\Http\Controllers\Agreements\WordMandatePFCAgreeController;
use App\Http\Controllers\Agreements\WordMandateAgreeController;
use App\Http\Controllers\Agreements\WordCollaborationAgreeController;
use App\Http\Controllers\Agreements\StageController;
use App\Http\Controllers\Agreements\SignerController;
use App\Http\Controllers\Agreements\ProgramResolutionController;
use App\Http\Controllers\Agreements\AgreementController;
use App\Http\Controllers\Agreements\AddendumController;
use App\Http\Controllers\Agreements\AccountabilityDetailController;
use App\Http\Controllers\Agreements\AccountabilityController;
use App\Http\Livewire\Warehouse\Cenabast\CenabastIndex;
use App\Http\Controllers\PurchasePlan\PurchasePlanController;

use App\Http\Controllers\PasswordResetController;
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
    return view('layouts.bt4.welcome');
})->name('welcome');


Route::get('/claveunica/callback', [ClaveUnicaController::class, 'callback'])->name('claveunica.callback');
Route::get('/claveunica/callback-testing', [ClaveUnicaController::class, 'callback']);
Route::get('/claveunica/login/{access_token}', [ClaveUnicaController::class, 'login'])->name('claveunica.login');
Route::get('/claveunica/login-external/{access_token}', [ClaveUnicaController::class, 'loginExternal']);
// Route::get('/claveunica/store/{access_token}', [ClaveUnicaController::class,'storeUserClaveUnica']);
Route::get('/claveunica/logout', [ClaveUnicaController::class, 'logout'])->name('logout');
Route::get('/claveunica/{route?}', [ClaveUnicaController::class, 'autenticar'])->name('claveunica.autenticar');

// Route::get('/siremx/logincu/{access_token}', [ClaveUnicaController::class,'siremx'])->name('claveunica.siremx');

Route::get('logout', [LoginController::class, 'logout'])->name('logout-local');

Auth::routes(['register' => false, 'logout' => false, 'reset' => false]);

Route::get('/login/external', [LoginController::class, 'showExternalLoginForm']);
Route::post('/login/external', [LoginController::class, 'externalLogin']);

/* Para testing, no he probado pero me la pedian en clave única */
Route::get('logout-testing', [LoginController::class, 'logout'])->name('logout-testing');


/* TODO: @sickiqq Chekear si necesitan o no middleware auth y mover al grupo que le corresponde */
Route::get('corrige_firmas', [ServiceRequestController::class, 'corrige_firmas'])->middleware('auth');
Route::get('last_contracts', [ServiceRequestController::class, 'last_contracts'])->name('last_contracts');
Route::get('existing_active_contracts/{start_date}/{end_date}', [ServiceRequestController::class, 'existing_active_contracts'])->name('existing_active_contracts');



/** Middleware Auth y Must Change Password */
Route::middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/open-notification/{notification}', [UserController::class, 'openNotification'])->name('openNotification');
    Route::get('/all-notifications', [UserController::class, 'allNotifications'])->name('allNotifications');
    Route::get('/clear-notifications', [UserController::class, 'clearNotifications'])->name('clearNotifications');

    Route::prefix('webservices')->name('webservices.')->group(function () {
        Route::get('fonasa', [WebserviceController::class, 'fonasa'])->name('fonasa');
    });
});


// acceso a usuarios verificación entrega de farmacias
Route::prefix('external_pharmacy')->name('external_pharmacy.')->group(function () {
    Route::get('confirmation_verification/{id}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'confirmationDispatchVerificationNotification'])->name('confirmation_verification');
    Route::get('cancel_verification/{id}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'cancelDispatchVerificationNotification'])->name('cancel_verification');
    Route::get('confirmation_wobservations_verification/{id}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'confirmationWithObservationsDispatchVerificationNotification'])->name('confirmation_wobservations_verification');
    Route::post('/store', [App\Http\Controllers\Pharmacies\DispatchController::class, 'storeVerification'])->name('store');
});



/* TODO: pasarlo al controller del usuario */
Route::post('/email/verification-notification/{user}', function (User $user) {
    $user->sendEmailVerificationNotification();
    return back()->with('success', 'El enlace de verificación se ha enviado al correo personal <b>' . $user->email_personal . '</b> para su confirmación.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');


/* TODO: no tiene auth */
Route::post('/{signaturesFlowId}/firma', [DigitalSignatureController::class, 'signPdfFlow'])->name('signPdfFlow');
Route::post('/firma', [DigitalSignatureController::class, 'signPdf'])->name('signPdf');
Route::get('/validador', [SignatureController::class, 'verify'])->name('verifyDocument');
Route::get('/test-firma/{otp}', [DigitalSignatureController::class, 'test']);


/** Link para VCs */
Route::get('vc/{alias}', [UserController::class, 'getVcLink'])->name('vc');

Route::middleware(['auth', 'must.change.password'])->group(function () {
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/subrogations', Subrogations::class)->name('subrogations');
        Route::get('/signature', MailSignature::class)->name('signature');
    });
});

/* Replacepent Staff */
Route::prefix('replacement_staff')->as('replacement_staff.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [ReplacementStaffController::class, 'index'])->name('index')->middleware(['role:Replacement Staff: admin|Replacement Staff: user rys']);
    Route::get('/{replacement_staff}/show_replacement_staff', [ReplacementStaffController::class, 'show_replacement_staff'])->name('show_replacement_staff');
    Route::get('/download_file/{replacement_staff}', [ReplacementStaffController::class, 'download'])->name('download_file');
    Route::get('/view_file/{replacement_staff}', [ReplacementStaffController::class, 'show_file'])->name('view_file');
    Route::get('/internal_create', [ReplacementStaffController::class, 'internal_create'])->name('internal_create');
    Route::post('/internal_store', [ReplacementStaffController::class, 'internal_store'])->name('internal_store');
    Route::prefix('staff_manage')->name('staff_manage.')->group(function () {
        Route::get('/', [StaffManageController::class, 'index'])->name('index');
        Route::get('/create', [StaffManageController::class, 'create'])->name('create');
        Route::post('/store', [StaffManageController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StaffManageController::class, 'edit'])->name('edit');
        Route::get('{organizational_unit_id}/destroy/{replacement_staff_id}', [StaffManageController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('view_profile')->name('view_profile.')->group(function () {
        Route::get('/download/{profile}', [ProfileController::class, 'download'])->name('download');
        Route::get('/show_file/{profile}', [ProfileController::class, 'show_file'])->name('show_file');
    });
    Route::prefix('view_training')->name('view_training.')->group(function () {
        Route::get('/download/{training}', [TrainingController::class, 'download'])->name('download');
        Route::get('/show_file/{training}', [TrainingController::class, 'show_file'])->name('show_file');
    });
    Route::prefix('request')->name('request.')->group(function () {
        Route::get('/', [RequestReplacementStaffController::class, 'index'])->name('index')->middleware('permission:Replacement Staff: assign request');
        Route::get('/assign_index', [RequestReplacementStaffController::class, 'assign_index'])->name('assign_index')->middleware('permission:Replacement Staff: technical evaluation');
        Route::get('/own_index', [RequestReplacementStaffController::class, 'own_index'])->name('own_index');
        Route::get('/personal_index', [RequestReplacementStaffController::class, 'personal_index'])->name('personal_index');
        Route::get('/pending_personal_index', [RequestReplacementStaffController::class, 'pending_personal_index'])->name('pending_personal_index');
        Route::get('/ou_index', [RequestReplacementStaffController::class, 'ou_index'])->name('ou_index');

        Route::get('/create', [RequestReplacementStaffController::class, 'create'])->name('create');
        Route::get('/create_replacement', [RequestReplacementStaffController::class, 'create_replacement'])->name('create_replacement');
        Route::get('/create_announcement', [RequestReplacementStaffController::class, 'create_announcement'])->name('create_announcement');

        Route::get('/{requestReplacementStaff}/create_extension', [RequestReplacementStaffController::class, 'create_extension'])->name('create_extension');
        Route::post('/{formType}/store', [RequestReplacementStaffController::class, 'store'])->name('store');
        Route::post('/{requestReplacementStaff}/store_extension/{formType}', [RequestReplacementStaffController::class, 'store_extension'])->name('store_extension');

        Route::get('/{requestReplacementStaff}/edit', [RequestReplacementStaffController::class, 'edit'])->name('edit');
        Route::get('/{requestReplacementStaff}/edit_replacement', [RequestReplacementStaffController::class, 'edit_replacement'])->name('edit_replacement');

        Route::put('/{requestReplacementStaff}/update', [RequestReplacementStaffController::class, 'update'])->name('update');
        Route::get('/to_select/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'to_select'])->name('to_select');
        Route::get('/to_sign_index', [RequestReplacementStaffController::class, 'to_sign_index'])->name('to_sign_index');
        Route::get('/to_sign/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'to_sign'])->name('to_sign');
        Route::get('/show_file/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'show_file'])->name('show_file');
        Route::get('/download/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'download'])->name('download');
        Route::get('/show_file_position/{position}', [RequestReplacementStaffController::class, 'show_file_position'])->name('show_file_position');
        Route::get('/show_verification_file/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'show_verification_file'])->name('show_verification_file');
        Route::get('/download_verification/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'download_verification'])->name('download_verification');
        Route::prefix('sign')->name('sign.')->group(function () {
            Route::put('/{requestSign}/{status}/{requestReplacementStaff}/update', [RequestSignController::class, 'update'])->name('update');
            Route::put('massive_update', [RequestSignController::class, 'massive_update'])->name('massive_update');
        });
        Route::get('/{requestReplacementStaff}/create_budget_availability_certificate_view', [RequestReplacementStaffController::class, 'create_budget_availability_certificate_view'])->name('create_budget_availability_certificate_view');
        Route::get('create_budget_availability_certificate_document/{requestReplacementStaff}/', [RequestReplacementStaffController::class, 'create_budget_availability_certificate_document'])->name('create_budget_availability_certificate_document');
        Route::get('/budget_availability_certificate_callbackSign/{message}/{modelId}/{signaturesFile?}', [RequestReplacementStaffController::class, 'callbackSign'])->name('callbackSign');
        Route::get('/show_budget_availability_certificate_signed/{requestReplacementStaff}', [RequestReplacementStaffController::class, 'show_budget_availability_certificate_signed'])->name('show_budget_availability_certificate_signed');

        Route::prefix('technical_evaluation')->name('technical_evaluation.')->group(function () {
            Route::get('/{requestReplacementStaff}/edit', [TechnicalEvaluationController::class, 'edit'])->name('edit');
            Route::get('/{requestReplacementStaff}/show', [TechnicalEvaluationController::class, 'show'])->name('show');
            Route::post('/store/{requestReplacementStaff}', [TechnicalEvaluationController::class, 'store'])->name('store');
            Route::post('/finalize_selection_process/{technicalEvaluation}', [TechnicalEvaluationController::class, 'finalize_selection_process'])->name('finalize_selection_process');
            Route::prefix('commission')->name('commission.')->group(function () {
                Route::post('/store/{technicalEvaluation}', [CommissionController::class, 'store'])->name('store');
                Route::delete('{commission}/destroy', [CommissionController::class, 'destroy'])->name('destroy');
            });
            Route::prefix('applicant')->name('applicant.')->group(function () {
                Route::post('/store/{technicalEvaluation}', [ApplicantController::class, 'store'])->name('store');
                Route::put('/{applicant}/update', [ApplicantController::class, 'update'])->name('update');
                Route::put('/{applicant}/update_to_select', [ApplicantController::class, 'update_to_select'])->name('update_to_select');
                Route::delete('{applicant}/destroy', [ApplicantController::class, 'destroy'])->name('destroy');
                Route::post('/decline_selected_applicant/{applicant}', [ApplicantController::class, 'decline_selected_applicant'])->name('decline_selected_applicant');
            });
            Route::prefix('file')->name('file.')->group(function () {
                Route::post('/store/{technicalEvaluation}', [TechnicalEvaluationFileController::class, 'store'])->name('store');
                Route::delete('{technicalEvaluationFile}/destroy', [TechnicalEvaluationFileController::class, 'destroy'])->name('destroy');
                Route::get('/show_file/{technicalEvaluationFile}', [TechnicalEvaluationFileController::class, 'show_file'])->name('show_file');
                Route::get('/download/{technicalEvaluationFile}', [TechnicalEvaluationFileController::class, 'download'])->name('download');
            });
            Route::prefix('selected_position')->name('selected_position.')->group(function () {
                Route::post('/store/{technicalEvaluation}', [SelectedPositionController::class, 'store'])->name('store');
            });
            Route::get('/create_document/{requestReplacementStaff}', [TechnicalEvaluationController::class, 'create_document'])->name('create_document');
        });
    });

    Route::prefix('contact_record')->name('contact_record.')->middleware(['role:Replacement Staff: admin|Replacement Staff: user rys'])->group(function () {
        Route::get('/{staff}', [ContactRecordController::class, 'index'])->name('index');
        Route::get('/{staff}/create/', [ContactRecordController::class, 'create'])->name('create');
        Route::post('/{staff}/store', [ContactRecordController::class, 'store'])->name('store');
        // Route::get('/{id}/edit', [StaffManageController::class, 'edit'])->name('edit');
        // Route::get('{organizational_unit_id}/destroy/{replacement_staff_id}', [StaffManageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        //Route::get('/replacement_staff_selected_report', [ReplacementStaffController::class, 'replacement_staff_selected_report'])->name('replacement_staff_selected_report');
        Route::get('/replacement_staff_historical', [ReplacementStaffController::class, 'replacement_staff_historical'])->name('replacement_staff_historical');
        Route::get('/request_by_dates', [RequestReplacementStaffController::class, 'request_by_dates'])->name('request_by_dates');
        Route::post('/search_request_by_dates', [RequestReplacementStaffController::class, 'search_request_by_dates'])->name('search_request_by_dates');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
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
        Route::prefix('manage')->name('manage.')->group(function () {
            Route::prefix('profession')->name('profession.')->group(function () {
                Route::get('/', [ProfessionManageController::class, 'index'])->name('index');
                Route::post('/store', [ProfessionManageController::class, 'store'])->name('store');
                Route::get('/{professionManage}/edit', [ProfessionManageController::class, 'edit'])->name('edit');
                Route::put('{professionManage}/update', [ProfessionManageController::class, 'update'])->name('update');
                Route::delete('{professionManage}/destroy', [ProfessionManageController::class, 'destroy'])->name('destroy');
            });
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [ProfileManageController::class, 'index'])->name('index');
                Route::post('/store', [ProfileManageController::class, 'store'])->name('store');
                Route::get('/{profileManage}/edit', [ProfileManageController::class, 'edit'])->name('edit');
                Route::put('{profileManage}/update', [ProfileManageController::class, 'update'])->name('update');
                Route::delete('{profileManage}/destroy', [ProfileManageController::class, 'destroy'])->name('destroy');
            });
            Route::prefix('legal_quality')->name('legal_quality.')->group(function () {
                Route::get('/', [LegalQualityManageController::class, 'index'])->name('index');
                Route::post('/store', [LegalQualityManageController::class, 'store'])->name('store');
                Route::get('/{legalQualityManage}/edit', [LegalQualityManageController::class, 'edit'])->name('edit');
                Route::post('{legalQualityManage}/assign_fundament', [LegalQualityManageController::class, 'assign_fundament'])->name('assign_fundament');
                // Route::delete('{profileManage}/destroy', [ProfileManageController::class, 'destroy'])->name('destroy');
            });
            Route::prefix('fundament')->name('fundament.')->group(function () {
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


/** Inicio Perfil de Cargos */
Route::prefix('job_position_profile')->as('job_position_profile.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [JobPositionProfileController::class, 'index'])->name('index');
    Route::get('/own_index', [JobPositionProfileController::class, 'own_index'])->name('own_index');
    Route::get('/index_review', [JobPositionProfileController::class, 'index_review'])->name('index_review');
    Route::get('/index_to_sign', [JobPositionProfileController::class, 'index_to_sign'])->name('index_to_sign');
    Route::get('/all_index', [JobPositionProfileController::class, 'all_index'])->name('all_index')->middleware('permission:Job Position Profile: all');
    Route::get('/create', [JobPositionProfileController::class, 'create'])->name('create');
    Route::get('/info/instructivo_2023', function () {
        return Storage::disk('gcs')->response('ionline/job_position_profile/info/instructivo_2023.pdf');
    })->name('instructivo_2023');
    Route::post('/store', [JobPositionProfileController::class, 'store'])->name('store');
    Route::get('{jobPositionProfile}/show/', [JobPositionProfileController::class, 'show'])->name('show');
    Route::get('{jobPositionProfile}/to_sign/', [JobPositionProfileController::class, 'to_sign'])->name('to_sign');
    Route::get('/{jobPositionProfile}/edit', [JobPositionProfileController::class, 'edit'])->name('edit');
    Route::put('{jobPositionProfile}/update', [JobPositionProfileController::class, 'update'])->name('update');
    Route::get('/{jobPositionProfile}/edit_formal_requirements', [JobPositionProfileController::class, 'edit_formal_requirements'])->name('edit_formal_requirements');
    Route::put('{jobPositionProfile}/update_formal_requirements/{generalRequirements}', [JobPositionProfileController::class, 'update_formal_requirements'])->name('update_formal_requirements');
    Route::get('{jobPositionProfile}/edit_objectives', [JobPositionProfileController::class, 'edit_objectives'])->name('edit_objectives');
    Route::put('{jobPositionProfile}/update_objectives', [JobPositionProfileController::class, 'update_objectives'])->name('update_objectives');
    Route::get('/{jobPositionProfile}/edit_organization', [JobPositionProfileController::class, 'edit_organization'])->name('edit_organization');
    Route::put('{jobPositionProfile}/update_organization', [JobPositionProfileController::class, 'update_organization'])->name('update_organization');
    Route::get('{jobPositionProfile}/edit_liabilities', [JobPositionProfileController::class, 'edit_liabilities'])->name('edit_liabilities');
    Route::post('{jobPositionProfile}/store_liabilities', [JobPositionProfileController::class, 'store_liabilities'])->name('store_liabilities');
    Route::put('{jobPositionProfile}/update_liabilities', [JobPositionProfileController::class, 'update_liabilities'])->name('update_liabilities');
    Route::get('{jobPositionProfile}/edit_expertise_map', [JobPositionProfileController::class, 'edit_expertise_map'])->name('edit_expertise_map');
    Route::post('{jobPositionProfile}/store_expertises', [JobPositionProfileController::class, 'store_expertises'])->name('store_expertises');
    Route::put('{jobPositionProfile}/update_expertises', [JobPositionProfileController::class, 'update_expertises'])->name('update_expertises');
    Route::delete('{jobPositionProfile}/destroy', [JobPositionProfileController::class, 'destroy'])->name('destroy');
    Route::prefix('sign')->name('sign.')->group(function () {
        Route::post('/{jobPositionProfile}/store', [JobPositionProfileSignController::class, 'store'])->name('store');
        Route::put('/{jobPositionProfileSign}/{status}/{jobPositionProfile}/update', [JobPositionProfileSignController::class, 'update'])->name('update');
    });
    Route::prefix('message')->name('message.')->group(function () {
        Route::post('/{jobPositionProfile}/store', [MessageController::class, 'store'])->name('store');
    });
    Route::prefix('document')->name('document.')->group(function () {
        Route::get('/create_document/{jobPositionProfile}', [JobPositionProfileController::class, 'create_document'])->name('create_document');
    });
});
/** Fin Perfil de Cargos */


/** Inicio Recursos */
Route::prefix('resources')->name('resources.')->middleware(['auth', 'must.change.password'])->group(function () {

    Route::get('report', [App\Http\Controllers\Resources\ReportController::class, 'report'])->name('report');
    Route::get('tic', TicResources::class)->name('tic');

    Route::prefix('telephones')->name('telephone.')->group(function () {
        Route::get('/', [TelephoneController::class, 'index'])->name('index');
        Route::get('create', [TelephoneController::class, 'create'])->name('create');
        Route::post('store', [TelephoneController::class, 'store'])->name('store');
        Route::get('{telephone}/edit', [TelephoneController::class, 'edit'])->name('edit');
        Route::put('{telephone}/update', [TelephoneController::class, 'update'])->name('update');
        Route::delete('{telephone}/destroy', [TelephoneController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('computers')->name('computer.')->group(function () {
        Route::get('/', [ComputerController::class, 'index'])->name('index');
        Route::get('create', [ComputerController::class, 'create'])->name('create');
        Route::post('store', [ComputerController::class, 'store'])->name('store');
        Route::get('{computer}/edit', [ComputerController::class, 'edit'])->name('edit');
        Route::put('{computer}/update', [ComputerController::class, 'update'])->name('update');
        Route::delete('{computer}/destroy', [ComputerController::class, 'destroy'])->name('destroy');
        Route::get('export', [ComputerController::class, 'export'])->name('export');
        Route::get('{computer}/inventory/{inventory}/fusion', ComputerFusion::class)->name('fusion');
        Route::get('inventory/{inventory}/create', ComputerCreate::class)->name('new');
    });
    Route::prefix('printers')->name('printer.')->group(function () {
        Route::get('/', [PrinterController::class, 'index'])->name('index');
        Route::get('create', [PrinterController::class, 'create'])->name('create');
        Route::post('store', [PrinterController::class, 'store'])->name('store');
        Route::get('{printer}/edit', [PrinterController::class, 'edit'])->name('edit');
        Route::put('{printer}/update', [PrinterController::class, 'update'])->name('update');
        Route::delete('{printer}/destroy', [PrinterController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('wingles')->name('wingle.')->group(function () {
        Route::get('/', [WingleController::class, 'index'])->name('index');
        Route::get('create', [WingleController::class, 'create'])->name('create');
        Route::post('store', [WingleController::class, 'store'])->name('store');
        Route::get('{wingle}/edit', [WingleController::class, 'edit'])->name('edit');
        Route::put('{wingle}/update', [WingleController::class, 'update'])->name('update');
        Route::delete('{wingle}/destroy', [WingleController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('mobiles')->name('mobile.')->group(function () {
        Route::get('/', [MobileController::class, 'index'])->name('index');
        Route::get('create', [MobileController::class, 'create'])->name('create');
        Route::post('store', [MobileController::class, 'store'])->name('store');
        Route::get('{mobile}/edit', [MobileController::class, 'edit'])->name('edit');
        Route::put('{mobile}/update', [MobileController::class, 'update'])->name('update');
        Route::delete('{mobile}/destroy', [MobileController::class, 'destroy'])->name('destroy');
    });
});
/** Fin Recursos */


/** Inicio Agreements */
Route::prefix('agreements')->as('agreements.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/{agreement}/accountability/create', [AccountabilityController::class, 'create'])->name('accountability.create');
    Route::post('/{agreement}/accountability', [AccountabilityController::class, 'store'])->name('accountability.store');
    Route::get('/{agreement}/accountability', [AccountabilityController::class, 'index'])->name('accountability.index');
    Route::get('/{agreement}/accountability/{accountability}/create', [AccountabilityDetailController::class, 'create'])->name('accountability.detail.create');
    Route::post('/{agreement}/accountability/{accountability}', [AccountabilityDetailController::class, 'store'])->name('accountability.detail.store');

    Route::delete('/agreements', [AgreementController::class, 'destroy'])->name('destroy');


    Route::post('stage', [StageController::class, 'store'])->name('stage.store');
    Route::put('/stage/{agreement_stage}', [AgreementController::class, 'updateStage'])->name('stage.update');
    Route::get('/stage/download/{file}', [StageController::class, 'download'])->name('stage.download');

    Route::get('/download/{file}', [AgreementController::class, 'download'])->name('download');
    Route::get('/downloadAgree/{file}', [AgreementController::class, 'downloadAgree'])->name('downloadAgree');
    Route::get('/downloadRes/{file}', [AgreementController::class, 'downloadRes'])->name('downloadRes');

    Route::get('/preview/{agreement}', [AgreementController::class, 'preview'])->name('preview');

    Route::resource('addendums', AddendumController::class);
    Route::post('/addendum/createWord/{addendum}/type/{type}', [WordTestController::class, 'createWordDocxAddendum'])->name('addendum.createWord');
    Route::post('/addendum/createWordWithdrawal/{addendum}/type/{type}', [WordWithdrawalAgreeController::class, 'createWordDocxAddendum'])->name('addendum.createWordWithdrawal');
    Route::get('/addendum/downloadRes/{addendum}', [AddendumController::class, 'downloadRes'])->name('addendum.downloadRes');
    Route::get('/addendum/sign/{addendum}/type/{type}', [AddendumController::class, 'sign'])->name('addendum.sign');
    Route::get('/addendum/preview/{addendum}', [AddendumController::class, 'preview'])->name('addendum.preview');
    Route::resource('programs', App\Http\Controllers\Agreements\ProgramController::class);
    Route::prefix('programs')->name('programs.')->group(function () {
        Route::resource('resolutions', ProgramResolutionController::class);
        Route::get('resolution/createWord/{program_resolution}', [WordTestController::class, 'createWordDocxResProgram'])->name('resolution.createWord');
        Route::get('resolution/download/{program_resolution}', [ProgramResolutionController::class, 'download'])->name('resolution.download');
        Route::post('resolution/amount/{program_resolution}', [ProgramResolutionController::class, 'storeAmount'])->name('resolution.amount.store');
        Route::put('resolution/amount/{resolution_amount}', [ProgramResolutionController::class, 'updateAmount'])->name('resolution.amount.update');
        Route::delete('resolution/amount/{resolution_amount}', [ProgramResolutionController::class, 'destroyAmount'])->name('resolution.amount.destroy');
    });
    Route::resource('municipalities', MunicipalityController::class);
    Route::resource('signers', SignerController::class);
    Route::put('/amount/{agreement_amount}', [AgreementController::class, 'updateAmount'])->name('amount.update');
    Route::delete('/amount/{agreement_amount}', [AgreementController::class, 'destroyAmount'])->name('amount.destroy');
    Route::put('/quota/{agreement_quota}', [AgreementController::class, 'updateQuota'])->name('quota.update');
    Route::put('/quotaAutomatic/{agreement_quota}', [AgreementController::class, 'updateAutomaticQuota'])->name('quotaAutomatic.update');

    Route::get('tracking', [AgreementController::class, 'indexTracking'])->name('tracking.index');
    //Route::get('createWord',[WordTestController::class,'createWordDocx'])->name('createWord.index');
    Route::get('/createWord/{agreement}', [WordTestController::class, 'createWordDocx'])->name('createWord');
    Route::post('/createWordRes/{agreement}', [WordTestController::class, 'createResWordDocx'])->name('createWordRes');
    Route::get('/createWordWithdrawal/{agreement}', [WordWithdrawalAgreeController::class, 'createWordDocx'])->name('createWordWithdrawal');
    Route::post('/createWordResWithdrawal/{agreement}', [WordWithdrawalAgreeController::class, 'createResWordDocx'])->name('createWordResWithdrawal');
    Route::get('/createWordCollaboration/{agreement}', [WordCollaborationAgreeController::class, 'createWordDocx'])->name('createWordCollaboration');
    Route::post('/createWordResCollaboration/{agreement}', [WordCollaborationAgreeController::class, 'createResWordDocx'])->name('createWordResCollaboration');
    Route::get('/createWordMandate/{agreement}', [WordMandateAgreeController::class, 'createWordDocx'])->name('createWordMandate');
    Route::get('/createWordMandatePFC/{agreement}', [WordMandatePFCAgreeController::class, 'createWordDocx'])->name('createWordMandatePFC');
    Route::get('/sign/{agreement}/type/{type}', [AgreementController::class, 'sign'])->name('sign');
});
/** Fin Agreements */



/* TODO #51 agrupar con middleware auth y revisar rutas que no se ocupen */
/** Programación Númerica APS */
Route::middleware(['auth', 'must.change.password'])->group(function () {
    Route::resource('programmings', ProgrammingController::class)->middleware('auth');
    Route::put('programmingStatus/{id}', [ProgrammingController::class, 'updateStatus'])->middleware('auth')->name('programmingStatus.update');
    // Route::get('programming/{programming}/show_total_rrhh', [ProgrammingController::class, 'show_total_rrhh'])->middleware('auth')->name('programming.show_total_rrhh');

    Route::resource('programmingitems', ProgrammingItemController::class)->middleware('auth');
    Route::post('/programmingitemsclone/{id}', [ProgrammingItemController::class, 'clone'])->name('programmingitems.clone');
    Route::delete('/programmingitems/{programmingitem}/pivot/{id}', [ProgrammingItemController::class, 'destroyProfessionalHour'])->name('programmingitems.destroyProfessionalHour');

    Route::resource('communefiles', CommuneFileController::class)->middleware('auth');
    Route::get('/downloadFileA/{file}', [CommuneFileController::class, 'download'])->name('programmingFile.download');
    Route::get('/downloadFileB/{file}', [CommuneFileController::class, 'downloadFileB'])->name('programmingFile.downloadFileB');
    Route::get('/downloadFileC/{file}', [CommuneFileController::class, 'downloadFileC'])->name('programmingFile.downloadFileC');

    Route::resource('reviews', ProgrammingReviewController::class)->middleware('auth');
    Route::resource('reviewItems', ReviewItemController::class)->middleware('auth');
    Route::put('reviewItemsRect/{id}', [ReviewItemController::class, 'updateRect'])->middleware('auth')->name('reviewItemsRect.update');
    Route::post('/reviewItems/acceptItems', [ReviewItemController::class, 'acceptItems'])->name('reviewItems.acceptItems');

    Route::resource('programmingdays', ProgrammingDayController::class)->middleware('auth');

    Route::prefix('participation')->as('participation.')->middleware('auth')->group(function () {
        Route::resource('tasks', TaskController::class)->except(['index']);
        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::resource('rescheduling', TaskReschedulingController::class);
        });
        Route::get('/{programming}', [ParticipationController::class, 'show'])->name('show');
        Route::get('/create/{programming}/{indicatorId}', [ParticipationController::class, 'create'])->name('create');
        Route::post('/{programming}', [ParticipationController::class, 'store'])->name('store');
        Route::get('/{value}/{programming}/edit', [ParticipationController::class, 'edit'])->name('edit');
        Route::put('/{value}', [ParticipationController::class, 'update'])->name('update');
        Route::delete('/{value}', [ParticipationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('emergencies')->as('emergencies.')->middleware('auth')->group(function () {
        Route::get('/{programming}', [EmergenciesController::class, 'show'])->name('show');
        Route::get('/create/{programming}', [EmergenciesController::class, 'create'])->name('create');
        Route::post('/{programming}', [EmergenciesController::class, 'store'])->name('store');
        Route::get('/{emergency}/edit', [EmergenciesController::class, 'edit'])->name('edit');
        Route::put('/{emergency}', [EmergenciesController::class, 'update'])->name('update');
        Route::delete('/{emergency}', [EmergenciesController::class, 'destroy'])->name('destroy');
    });

    Route::resource('professionals', ProfessionalController::class)->middleware('auth');
    Route::resource('actiontypes', ActionTypeController::class)->middleware('auth');
    Route::resource('ministerialprograms', MinisterialProgramController::class)->middleware('auth');

    Route::resource('activityprograms', ActivitiesProgramController::class)->middleware('auth');
    Route::resource('activityitems', ActivitiesItemController::class)->middleware('auth');

    Route::resource('professionalhours', ProfessionalHourController::class)->middleware('auth');

    Route::resource('trainingitems', TrainingsItemController::class)->middleware('auth');

    Route::resource('pendingitems', ProgrammingActivityItemController::class)->middleware('auth');

    //Reportes de Programación Númerica APS
    Route::get('reportConsolidated', [ProgrammingReportController::class, 'reportConsolidated'])->middleware('auth')->name('programming.reportConsolidated');
    Route::get('reportConsolidatedSep', [ProgrammingReportController::class, 'reportConsolidatedSep'])->middleware('auth')->name('programming.reportConsolidatedSep');
    Route::get('reportUsers', [ProgrammingReportController::class, 'reportUsers'])->middleware('auth')->name('programming.reportUsers');
    Route::get('reportTotalRrhh', [ProgrammingReportController::class, 'reportTotalRrhh'])->middleware('auth')->name('programming.reportTotalRrhh');
    //Reportes Observaciones de Programación Númerica APS
    Route::get('reportObservation', [ProgrammingReportController::class, 'reportObservation'])->middleware('auth')->name('programming.reportObservation');
});
//End Programación Númerica APS


Route::resource('agreements', AgreementController::class)->middleware('auth');

/** assigments */
Route::resource('assigment', AssigmentController::class)->middleware('auth');
Route::post('assigment.import', [AssigmentController::class, 'import'])->name('assigment.import');


Route::prefix('integrity')->as('integrity.')->group(function () {
    Route::get('complaints/download/{complaint}', [App\Http\Controllers\Integrity\ComplaintController::class, 'download'])->name('complaints.download')->middleware('auth');
    Route::get('complaints/mail/{complaint}', [App\Http\Controllers\Integrity\ComplaintController::class, 'mail'])->name('complaints.mail');
    Route::resource('complaints', App\Http\Controllers\Integrity\ComplaintController::class);
});

Route::prefix('rrhh')->as('rrhh.')->group(function () {

    Route::prefix('absence-types')->name('absence-types.')->group(function () {
        Route::get('/', [AbsenteeismTypeController::class, 'index'])->name('index');
        Route::get('/create', [AbsenteeismTypeController::class, 'create'])->name('create');
        Route::post('/store', [AbsenteeismTypeController::class, 'store'])->name('store');
        Route::put('/{absenteeismType}', [AbsenteeismTypeController::class, 'update'])->name('update');
    });



    Route::get('{user}/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('auth');
    Route::post('{user}/roles', [RoleController::class, 'attach'])->name('roles.attach')->middleware('auth');

    /* TODO: #50 incorporar auth en el grupo e importar controllers al comienzo del archivo */
    /** Inicio Shift Managment */
    Route::prefix('shift-management')->group(function () {

        Route::get('/next', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'goToNextMonth'])->name('shiftManag.nextMonth')->middleware('auth');
        Route::get('/prev', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'goToPreviousMonth'])->name('shiftManag.prevMonth')->middleware('auth');

        Route::get('/myshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'myShift'])->name('shiftManag.myshift')->middleware('auth');
        Route::get('/seeShiftControlForm', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'seeShiftControlForm'])->name('shiftManag.seeShiftControlForm')->middleware('auth');


        Route::get('/closeshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'closeShift'])->name('shiftManag.closeShift')->middleware('auth');
        Route::post('/closeshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'closeShift'])->name('shiftManag.closeShift')->middleware('auth');
        Route::get('/closeshift/download/{id}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'downloadCloseInXls'])->name('shiftManag.closeShift.download')->middleware('auth');

        Route::post('/closeshift/first', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'firstConfirmation'])->name('shiftManag.closeShift.firstConfirmation')->middleware('auth');
        Route::post('/closeshift/close', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'closeDaysConfirmation'])->name('shiftManag.closeShift.closeConfirmation')->middleware('auth');

        Route::post('/closeshift/saveclosedate/{new?}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'saveClose'])->name('shiftManag.closeShift.saveDate')->middleware('auth');

        Route::post('/shiftupdate', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'changeShiftUserCommentary'])->name('shiftManag.shiftupdate')->middleware('auth');

        Route::get('/shiftreports', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'shiftReports'])->name('shiftManag.shiftReports')->middleware('auth');
        Route::post('/shiftreports', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'shiftReports'])->name('shiftManag.shiftReports')->middleware('auth');
        Route::get('/shiftreports/XLSdownload', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'shiftReportsXLSDownload'])->name('shiftManag.shiftReportsXLSdownload')->middleware('auth');

        Route::get('/shiftdashboard', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'shiftDashboard'])->name('shiftManag.shiftDashboard')->middleware('auth');
        Route::get('/available-shifts', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'availableShifts'])->name('shiftManag.availableShifts')->middleware('auth');
        Route::post('/available-shifts/applyfor', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'applyForAvailableShifts'])->name('shiftManag.availableShifts.applyfor')->middleware('auth');
        Route::post('/available-shifts/cancelDay', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'cancelShiftRequest'])->name('shiftManag.availableShifts.cancelRequest')->middleware('auth');
        Route::post('/available-shifts/approvalRequest', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'approveShiftRequest'])->name('shiftManag.availableShifts.approvalRequest')->middleware('auth');
        Route::post('/available-shifts/rejectRequest', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'rejectShiftRequest'])->name('shiftManag.availableShifts.rejectRequest')->middleware('auth');
        Route::get('/myshift/confirm/{day}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'myShiftConfirm'])->name('shiftManag.myshift.confirmDay')->middleware('auth');
        Route::get('/myshift/reject/{day}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'myShiftReject'])->name('shiftManag.myshift.rejectDay')->middleware('auth');

        Route::get('/reject/{day}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'adminShiftConfirm'])->name('shiftManag.confirmDay')->middleware('auth');


        Route::post('/myshift', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'myShift'])->name('shiftManag.myshiftfiltered')->middleware('auth');



        Route::post('/shift-control-form/download', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'downloadShiftControlInPdf'])->name('shiftManag.downloadform')->middleware('auth');


        Route::post('/', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'indexfiltered'])->name('shiftManag.indexF')->middleware('auth');
        Route::post('/assign', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'assignStaff'])->name('shiftsTypes.assign')->middleware('auth');
        Route::post('/deleteassign', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'assignStaff'])->name('shiftsTypes.deleteassign')->middleware('auth');
        Route::get('/downloadShiftInXls', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'downloadShiftInXls'])->name('shiftsTypes.downloadShiftInXls')->middleware('auth');

        Route::get('/shiftstypes', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'shiftstypesindex'])->name('shiftsTypes.index')->middleware('auth');
        Route::get('/newshifttype', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'index'])->name('shiftsTypes.new')->middleware('auth');
        Route::get('/newshifttype/', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'newshifttype'])->name('shiftsTypes.create')->middleware('auth');
        Route::get('/editshifttype/{id}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'editshifttype'])->name('shiftsTypes.edit')->middleware('auth');
        Route::post('/updateshifttype', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'updateshifttype'])->name('shiftsTypes.update')->middleware('auth');
        Route::post('/storeshifttype', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'storenewshift'])->name('shiftsTypes.store')->middleware('auth');



        Route::get('/{groupname?}', [App\Http\Controllers\Rrhh\ShiftManagementController::class, 'index'])->name('shiftManag.index')->middleware('auth');
    });
    /** Fin Shift Managment */

    Route::prefix('attendance')->name('attendance.')->middleware(['auth', 'must.change.password'])->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/import', [AttendanceController::class, 'import'])->name('import');
        Route::post('/store', [AttendanceController::class, 'store'])->name('store');

        Route::get('no-records', NoAttendanceRecordIndex::class)->name('no-records.index');
        Route::get('no-records-mgr', NoAttendanceRecordMgr::class)->name('no-records.mgr');
        Route::get('no-records/{no_attendance_record_id}', [NoAttendanceRecordController::class,'show'])->name('no-records.show');
        Route::get('no-records/{noAttendanceRecord}/confirmation', NoAttendanceRecordConfirmation::class)->name('no-records.confirmation');
        Route::get('reasons', ReasonMgr::class)->name('reason.mgr');
    });


    /** Rutas modulo honorarios */
    Route::prefix('service-request')->name('service-request.')->middleware(['auth', 'must.change.password'])->group(function () {

        Route::get('/profile/{user?}/{year?}/{type?}/{serviceRequest?}/{period?}', [ProfileControllerSr::class, 'show'])->name('show');
        Route::post('/profile', [ProfileControllerSr::class, 'show'])->name('show.post');


        // Rutas de service request
        Route::get('/test', [ServiceRequestController::class, 'test'])->name('test');
        Route::get('/home', function () {
            return view('service_requests.home');
        })->name('home');

        Route::match(['get', 'post'], '/user', [ServiceRequestController::class, 'user'])->name('user');

        /** descomposición del resource */
        // Route::get('/', [ServiceRequestController::class, 'index'])->name('index');
        Route::get('/index_bak}', [ServiceRequestController::class, 'index_bak'])->name('index_bak');
        Route::get('/index/{type}', [ServiceRequestController::class, 'index'])->name('index');
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
            Route::get('{fulfillment}/destroy', [FulfillmentController::class, 'destroy'])->name('destroy');
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
            Route::get('/program_consolidated_report', [ServiceRequestController::class, 'program_consolidated_report'])->name('program_consolidated_report');
            Route::get('/active_contracts_report', [ServiceRequestController::class, 'active_contracts_report'])->name('active_contracts_report');

            Route::get('/consolidated-data-excel-download/{establishment_id}/{year}/{semester}', [ServiceRequestController::class, 'consolidated_data_excel_download'])->name('consolidated_data_excel_download');
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

    /** Fin Rutas Honorarios */


    /**
     * Reemplazar después por el nuevo
     */
    //Route::resource('authorities', AuthorityController::class)->middleware(['auth']);

    Route::prefix('authorities')->name('new-authorities.')->middleware(['auth', 'must.change.password'])->group(function () {
        Route::get('/test', [AuthorityController::class, 'test'])->name('test');
        Route::get('/', [AuthorityController::class, 'index'])->name('index');
        Route::get('/calendar/{organizationalUnit}', App\Http\Livewire\Authorities\Calendar::class);
        Route::get('/{organizationalUnit}/create', [AuthorityController::class, 'create'])->name('create');
        Route::get('/{organizationalUnit}/calendar', [AuthorityController::class, 'calendar'])->name('calendar');
        Route::post('/store', [AuthorityController::class, 'store'])->name('store');
        Route::put('/{organizationalUnit}/update', [AuthorityController::class, 'update'])->name('update');
        Route::get('/{organizationalUnit}/create-subrogant', [AuthorityController::class, 'create_subrogant'])->name('create_subrogant');
    });

    Route::prefix('subrogations')->name('subrogations.')->middleware(['auth', 'must.change.password'])->group(function () {
        Route::get('/{organizationalUnit}/create', [SubrogationController::class, 'create'])->name('create');
        Route::post('/store', [SubrogationController::class, 'store'])->name('store');
    });

    Route::prefix('organizational-units')->name('organizational-units.')->middleware(['auth', 'must.change.password'])->group(function () {
        Route::get('/', [OrganizationalUnitController::class, 'index'])->name('index')->middleware('auth');
        Route::get('/create', [OrganizationalUnitController::class, 'create'])->name('create')->middleware('auth');
        Route::post('/store', [OrganizationalUnitController::class, 'store'])->name('store')->middleware('auth');
        Route::get('{organizationalUnit}/edit', [OrganizationalUnitController::class, 'edit'])->name('edit')->middleware('auth');
        Route::put('{organizationalUnit}', [OrganizationalUnitController::class, 'update'])->name('update')->middleware('auth');
        Route::delete('{organizationalUnit}/destroy', [OrganizationalUnitController::class, 'destroy'])->name('destroy')->middleware('auth');
    });

    // Se saca el directorio ya que no debería tener acceso los usuarios logeado solamente
    Route::get('/directory/{establishment?}/{organizationalUnit?}', [UserController::class, 'directory'])->name('users.directory');

    Route::prefix('users')->name('users.')->middleware(['auth'])->group(function () {
        Route::get('ou/{ou_id?}', [UserController::class, 'getFromOu'])->name('get.from.ou');
        Route::get('autority/{ou_id?}', [UserController::class, 'getAutorityFromOu'])->name('get.autority.from.ou');

        Route::get('password', [UserController::class, 'editPassword'])->name('password.edit');
        Route::put('password', [UserController::class, 'updatePassword'])->name('password.update');

        Route::put('{user}/password', [UserController::class, 'resetPassword'])->name('password.reset');
        Route::get('{user}/switch', [UserController::class, 'switch'])->name('switch');

        Route::post('/importBirthdays', [UserController::class, 'importBirthdays'])->name('importBirthdays');
        Route::view('birthdayGrettings', 'rrhh.birthday_import.index')->name('birthdayGrettings');

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

        Route::get('/{user}/access-logs', App\Http\Livewire\Parameters\AccessLogIndex::class)->name('access-logs');

        Route::get('/last-access', [UserController::class, 'lastAccess'])->name('last-access');

        Route::prefix('service_requests')->name('service_requests.')->group(function () {
            Route::get('/', [UserController::class, 'index_sr'])->name('index')->middleware('auth');
            Route::get('/create', [UserController::class, 'create_sr'])->name('create')->middleware('auth');
            Route::post('/', [UserController::class, 'store_sr'])->name('store')->middleware('auth');
            Route::get('/{user}/edit', [UserController::class, 'edit_sr'])->name('edit')->middleware('auth');
            Route::put('/{user}', [UserController::class, 'update_sr'])->name('update')->middleware('auth');
            Route::delete('/{user}', [UserController::class, 'destroy_sr'])->name('destroy')->middleware('auth');
        });
    });
});

Route::prefix('parameters')->as('parameters.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [ParameterController::class, 'welcome'])->name('welcome');
    Route::get('/all', ParameterIndex::class)->name('index');
    Route::get('/create', ParameterCreate::class)->name('create');
    Route::get('/{parameter}/edit', ParameterEdit::class)->name('edit');
    Route::put('/{parameter}', [ParameterController::class, 'update'])->name('update');
    Route::get('drugs', [ParameterController::class, 'indexDrugs'])->name('drugs')->middleware(['role:Drugs: admin']);
    //Route::resource('permissions', PermissionController::class);
    Route::prefix('permissions')->as('permissions.')->group(function () {
        Route::get('/create/{guard}', [PermissionController::class, 'create'])->name('create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::get('/{guard}', [PermissionController::class, 'index'])->name('index');
        Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('update');
        Route::delete('{permission}/destroy', [PermissionController::class, 'destroy'])->name('destroy');
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

    /* FIXME: hay dos RoleControllers */
    Route::resource('roles', App\Http\Controllers\Parameters\RoleController::class);

    Route::prefix('communes')->as('communes.')->group(function () {
        Route::get('/', [CommuneController::class, 'index'])->name('index');
        Route::put('/{commune}', [CommuneController::class, 'update'])->name('update');
    });

    Route::prefix('establishments')->as('establishments.')->group(function () {
        Route::get('/', [EstablishmentController::class, 'index'])->name('index');
        Route::get('/create', [EstablishmentController::class, 'create'])->name('create');
        Route::post('/store', [EstablishmentController::class, 'store'])->name('store');
        Route::put('/{establishment}', [EstablishmentController::class, 'update'])->name('update');
        Route::get('/{establishment}/edit', [EstablishmentController::class, 'edit'])->name('edit');
    });

    Route::prefix('establishment-types')->as('establishment_types.')->group(function () {
        Route::get('/', [EstablishmentTypeController::class, 'index'])->name('index');
        Route::get('/create', [EstablishmentTypeController::class, 'create'])->name('create');
        Route::post('/store', [EstablishmentTypeController::class, 'store'])->name('store');
        Route::get('/{establishmentType}/edit', [EstablishmentTypeController::class, 'edit'])->name('edit');
        Route::put('/{establishmentType}/update', [EstablishmentTypeController::class, 'update'])->name('update');
    });

    Route::get('/holidays', App\Http\Livewire\Parameters\Holidays::class)->name('holidays');
    Route::get('/health-services', App\Http\Livewire\HealthServices::class)->name('health-services');

    Route::prefix('establishment/{establishment}/locations')->as('locations.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::get('/edit/{location}', [LocationController::class, 'edit'])->name('edit');
        Route::put('/update/{location}', [LocationController::class, 'update'])->name('update');
        Route::post('/store', [LocationController::class, 'store'])->name('store');
    });

    Route::prefix('establishment/{establishment}/places')->as('places.')->group(function () {
        Route::get('/', MaintainerPlaces::class)->name('index');
    });

    Route::prefix('phrases')->as('phrases.')->group(function () {
        Route::get('/', [PhraseOfTheDayController::class, 'index'])->name('index');
        Route::get('/create', [PhraseOfTheDayController::class, 'create'])->name('create');
        Route::get('/edit/{phrase}', [PhraseOfTheDayController::class, 'edit'])->name('edit');
        Route::put('/update/{phrase}', [PhraseOfTheDayController::class, 'update'])->name('update');
        Route::post('/store', [PhraseOfTheDayController::class, 'store'])->name('store');
    });

    Route::prefix('measurements')->as('measurements.')->group(function () {
        Route::get('/', [UnitOfMeasurementController::class, 'index'])->name('index');
        Route::get('/create', [UnitOfMeasurementController::class, 'create'])->name('create');
        Route::get('/edit/{measurement}', [UnitOfMeasurementController::class, 'edit'])->name('edit');
        Route::put('/update/{measurement}', [UnitOfMeasurementController::class, 'update'])->name('update');
        Route::post('/store', [UnitOfMeasurementController::class, 'store'])->name('store');
    });

    Route::prefix('budgetitems')->as('budgetitems.')->group(function () {
        Route::get('/', [BudgetItemController::class, 'index'])->name('index');
        Route::get('/create', [BudgetItemController::class, 'create'])->name('create');
        Route::get('/edit/{budgetItem}', [BudgetItemController::class, 'edit'])->name('edit');
        Route::put('/update/{budgetItem}', [BudgetItemController::class, 'update'])->name('update');
        Route::post('/store', [BudgetItemController::class, 'store'])->name('store');
    });

    Route::prefix('purchasemechanisms')->as('purchasemechanisms.')->group(function () {
        Route::get('/', [PurchaseMechanismController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseMechanismController::class, 'create'])->name('create');
        Route::get('/edit/{purchaseMechanism}', [PurchaseMechanismController::class, 'edit'])->name('edit');
        Route::put('/update/{purchaseMechanism}', [PurchaseMechanismController::class, 'update'])->name('update');
        Route::post('/store', [PurchaseMechanismController::class, 'store'])->name('store');
    });

    Route::prefix('purchasetypes')->as('purchasetypes.')->group(function () {
        Route::get('/', [PurchaseTypeController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseTypeController::class, 'create'])->name('create');
        Route::get('/edit/{purchaseType}', [PurchaseTypeController::class, 'edit'])->name('edit');
        Route::put('/update/{purchaseType}', [PurchaseTypeController::class, 'update'])->name('update');
        Route::post('/store', [PurchaseTypeController::class, 'store'])->name('store');
    });

    Route::prefix('purchaseunits')->as('purchaseunits.')->group(function () {
        Route::get('/', [PurchaseUnitController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseUnitController::class, 'create'])->name('create');
        Route::get('/edit/{purchaseUnit}', [PurchaseUnitController::class, 'edit'])->name('edit');
        Route::put('/update/{purchaseUnit}', [PurchaseUnitController::class, 'update'])->name('update');
        Route::post('/store', [PurchaseUnitController::class, 'store'])->name('store');
    });

    Route::prefix('suppliers')->as('suppliers.')->group(function () {
        Route::get('/', [App\Http\Controllers\Parameters\SupplierController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Parameters\SupplierController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Parameters\SupplierController::class, 'store'])->name('store');
        Route::get('/edit/{supplier}', [App\Http\Controllers\Parameters\SupplierController::class, 'edit'])->name('edit');
        Route::put('/update/{supplier}', [App\Http\Controllers\Parameters\SupplierController::class, 'update'])->name('update');
    });

    Route::prefix('cutoffdates')->as('cutoffdates.')->group(function () {
        Route::get('/', [App\Http\Controllers\Parameters\CutOffDateController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Parameters\CutOffDateController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Parameters\CutOffDateController::class, 'store'])->name('store');
        Route::get('/edit/{cut_off_date}', [App\Http\Controllers\Parameters\CutOffDateController::class, 'edit'])->name('edit');
        Route::put('/update/{cut_off_date}', [App\Http\Controllers\Parameters\CutOffDateController::class, 'update'])->name('update');
    });

    Route::prefix('logs')->name('logs.')->middleware('auth')->group(function () {
        Route::get('/{module?}', [LogController::class, 'index'])->name('index');
        Route::get('/show/{log}', [LogController::class, 'show'])->name('show')->where('id', '[0-9]+');
        // Route::get('{log}/edit', [LogController::class, 'edit'])->name('edit');
        // Route::put('{log}', [LogController::class, 'update'])->name('update');
        Route::get('{log}/destroy', [LogController::class, 'destroy'])->name('destroy');
    });

    Route::get('/programs/budgets', BudgetMgr::class)->name('budgetMgr');

    Route::resource('programs', ParametersProgramController::class)->only(['index', 'create', 'edit']);

    Route::prefix('labels')->as('labels.')->group(function () {
        Route::get('/{module}', InventoryLabelIndex::class)->name('index');
        Route::get('/create/{module}', [InventoryLabelController::class, 'create'])->name('create');
        Route::post('/store', [InventoryLabelController::class, 'store'])->name('store');
        Route::get('/edit/{inventoryLabel}', [InventoryLabelController::class, 'edit'])->name('edit');
        Route::put('/{inventoryLabel}/label', [InventoryLabelController::class, 'update'])->name('update');
    });
});
/** Fin de rutas de parametros */

Route::prefix('documents')->as('documents.')->middleware(['auth', 'must.change.password'])->group(function () {

    Route::get('lobby', MeetingMgr::class)->name('lobby.manager');
    Route::get('lobby/{meeting}', MeetingShow::class)->name('lobby.show');

    Route::post('/create_from_previous', [DocumentController::class, 'createFromPrevious'])->name('createFromPrevious');
    Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
    Route::put('/{document}/store_number', [DocumentController::class, 'storeNumber'])->name('store_number');
    Route::delete('/{document}/delete_file', [DocumentController::class, 'deleteFile'])->name('delete_file');
    Route::get('/add_number', [DocumentController::class, 'addNumber'])->name('add_number');
    Route::post('/find', [DocumentController::class, 'find'])->name('find');
    Route::get('/report', [DocumentController::class, 'report'])->name('report');
    Route::get('/{document}/sendForSignature/v2', [DocumentController::class, 'sendForSign'])->name('sendForSign.v2');
    Route::get('/{document}/show-document/v2', [DocumentController::class, 'showDocument'])->name('show.document');
    Route::get('/{document}/sendForSignature/', [DocumentController::class, 'sendForSignature'])->name('sendForSignature');
    Route::get('/signed-document-pdf/{id}', [DocumentController::class, 'signedDocumentPdf'])->name('signedDocumentPdf');

    Route::prefix('partes')->as('partes.')->group(function () {
        // Route::get('/',[ParteController::class,'index'])->name('index');
        Route::post('/', [ParteController::class, 'store'])->name('store');
        Route::get('/create', [ParteController::class, 'create'])->name('create');
        Route::get('/download/{file}',  [ParteController::class, 'download'])->name('download');
        Route::delete('/files/{file}', [ParteFileController::class, 'destroy'])->name('files.destroy');
        Route::get('/inbox', [ParteController::class, 'inbox'])->name('inbox');

        Route::get('/', App\Http\Livewire\Documents\Partes\Inbox::class)->name('index');
        Route::get('/outbox', [ParteController::class, 'outbox'])->name('outbox');
        Route::get('report-by-dates', App\Http\Livewire\Documents\Partes\ReportByDates::class)->name('report-by-dates');
        Route::get('/view/{parte}', [ParteController::class, 'view'])->name('view');
        Route::get('/{parte}', [ParteController::class, 'show'])->name('show');
        Route::put('/{parte}', [ParteController::class, 'update'])->name('update');
        Route::delete('/{parte}', [ParteController::class, 'destroy'])->name('destroy');
        Route::get('/{parte}/edit', [ParteController::class, 'edit'])->name('edit');
    });

    Route::get('signatures/index/{tab}', [SignatureController::class, 'index'])->name('signatures.index');
    Route::get('signatures/create/{xAxis?}/{yAxis?}', [SignatureController::class, 'create'])->name('signatures.create');
    Route::resource('signatures', SignatureController::class)->except(['index', 'create']);
    Route::get('/showPdf/{signaturesFile}/{timestamp?}', [SignatureController::class, 'showPdf'])->name('signatures.showPdf');
    Route::post('/showPdfFromFile', [SignatureController::class, 'showPdfFromFile'])->name('signatures.showPdfFromFile');
    Route::get('/showPdfAnexo/{anexo}', [SignatureController::class, 'showPdfAnexo'])->name('signatures.showPdfAnexo');
    Route::get('/download-anexo/{anexo}', [SignatureController::class, 'downloadAnexo'])->name('signatures.downloadAnexo');
    Route::post('/{idSignaturesFlow}/rechazar', [SignatureController::class, 'rejectSignature'])->name('signatures.rejectSignature');
    Route::get('signatures/signatureFlows/{signatureId}', [SignatureController::class, 'signatureFlows'])->name('signatures.signatureFlows');
    Route::get('signatures/signModal/{pendingSignaturesFlowId}', [SignatureController::class, 'signModal'])->name('signatures.signModal');
    Route::get('signatures/massSignModal/{pendingSignaturesFlowIds}', [SignatureController::class, 'massSignModal'])->name('signatures.massSignModal');
    Route::get('/callback_firma/{message}/{modelId}/{signaturesFile?}', [SignatureController::class, 'callbackFirma'])->name('callbackFirma');

    Route::get('/approvals/{approval?}', ApprovalsMgr::class)->name('approvals');
    Route::get('/approvals/{approval}/pdf', [NoAttendanceRecordController::class,'signedApproval'])->name('signed.approval.pdf');

});

Route::resource('documents', DocumentController::class)->middleware(['auth', 'must.change.password']);

Route::prefix('requirements')->as('requirements.')->middleware(['auth', 'must.change.password'])->group(function () {
    /** Custom routes */
    Route::get('download/{file}',  [EventController::class, 'download'])->name('download');
    Route::get('deleteFile/{file}',  [EventController::class, 'deleteFile'])->name('deleteFile');
    Route::get('outbox', [RequirementController::class, 'outbox'])->name('outbox');
    Route::get('secretary_outbox', [RequirementController::class, 'secretary_outbox'])->name('secretary_outbox');
    Route::get('archive_requirement/{requirement}', [RequirementController::class, 'archive_requirement'])->name('archive_requirement');
    Route::get('archive_requirement_delete/{requirement}', [RequirementController::class, 'archive_requirement_delete'])->name('archive_requirement_delete');
    // Route::get('asocia_categorias', [RequirementController::class,'asocia_categorias'])->name('asocia_categorias');
    Route::get('create_requirement/{parte}',  [RequirementController::class, 'create_requirement'])->name('create_requirement');
    Route::get('create-from-parte/{parte?}',  [RequirementController::class, 'createFromParte'])->name('createFromParte');
    Route::get('create_requirement_sin_parte',  [RequirementController::class, 'create_requirement_sin_parte'])->name('create_requirement_sin_parte');
    // Route::get('create_event/{req_id}',  [EventController::class,'create_event'])->name('create_event');
    Route::resource('labels', LabelController::class);
    Route::resource('events', EventController::class);
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('report1', [RequirementController::class, 'report1'])->name('report1');
    // Route::get('report_reqs_by_org', [RequirementController::class,'report_reqs_by_org])->name('report_reqs_by_org');

    //Route::get('/', [RequirementController::class,'outbox'])->name('index');
    //Route::get('inbox/{user?}', [RequirementController::class,'inbox'])->name('inbox');
    Route::get('/inbox/{user?}', [RequirementController::class, 'inbox'])->name('inbox');

    Route::get('/create', [RequirementController::class, 'show'])->name('create');
    Route::post('/', [RequirementController::class, 'store'])->name('store');
    Route::post('/directorStore', [RequirementController::class, 'director_store'])->name('directorStore');
    Route::get('/{requirement}', [RequirementController::class, 'show'])->name('show');
    Route::delete('/{requirement}', [RequirementController::class, 'destroy'])->name('destroy');

});

Route::view('calendars', 'calendars.index')->name('calendars');

Route::prefix('indicators')->as('indicators.')->group(function () {
    Route::get('/', function () {
        return view('indicators.index');
    })->name('index');

    Route::get('/population', [SingleParameterController::class, 'population'])->name('population');
    Route::resource('single_parameter', SingleParameterController::class)->middleware('auth');
    Route::post('/population/export', [SingleParameterController::class, 'export'])->name('population.export');
    Route::get('/population/percapita/{year}', function ($year) {
        return Storage::disk('gcs')->response('ionline/population/percapita_preliminar_' . $year . '.xlsx');
    })->name('population.percapita');

    Route::prefix('rni_db')->as('rni_db.')->group(function () {
        Route::get('/', [RNIdbController::class, 'index'])->middleware('auth')->name('index');
        Route::put('/', [RNIdbController::class, 'update'])->middleware('auth')->name('update');
        Route::get('/{file}', [RNIdbController::class, 'download'])->middleware('auth')->name('download');
        Route::post('/{file}', [RNIdbController::class, 'add_user'])->middleware('auth')->name('add_user');
        Route::delete('/{file}', [RNIdbController::class, 'revoke_user'])->middleware('auth')->name('revoke_user');
    });

    Route::prefix('comges')->as('comges.')->middleware(['auth', 'must.change.password'])->group(function () {
        Route::get('/', [ComgesController::class, 'index'])->name('index');
        Route::get('/{year}', [ComgesController::class, 'list'])->name('list');
        Route::post('/{year}', [ComgesController::class, 'store'])->name('store');
        Route::get('/{year}/create', [ComgesController::class, 'create'])->middleware('auth')->name('create');
        Route::get('/{comges}/edit', [ComgesController::class, 'edit'])->middleware('auth')->name('edit');
        Route::put('/{comges}', [ComgesController::class, 'update'])->middleware('auth')->name('update');
        Route::get('/{year}/{comges}/corte/{section}', [ComgesController::class, 'show'])->name('show');
        Route::get('/{year}/{comges}/corte/{section}/ind/{indicator}/create', [ComgesController::class, 'createAction'])->middleware('auth')->name('action.create');
        Route::get('/{year}/{comges}/corte/{section}/ind/{indicator}/action/{action}/edit', [ComgesController::class, 'editAction'])->middleware('auth')->name('action.edit');
        Route::put('/{year}/{comges}/corte/{section}/ind/{indicator}/action/{action}', [ComgesController::class, 'updateAction'])->middleware('auth')->name('action.update');
        Route::post('/{year}/{comges}/corte/{section}/ind/{indicator}', [ComgesController::class, 'storeAction'])->middleware('auth')->name('action.store');
    });

    Route::prefix('health_goals')->as('health_goals.')->group(function () {
        Route::get('/show_file/{attachedFile}', [HealthGoalController::class, 'show_file'])->name('ind.show_file');
        Route::delete('/{attachedFile}', [HealthGoalController::class, 'destroy_file'])->middleware('auth')->name('ind.value.destroy_file');
        Route::get('/{law}', [HealthGoalController::class, 'index'])->name('index');
        Route::get('/{law}/{year}', [HealthGoalController::class, 'list'])->name('list');
        Route::get('/{law}/{year}/{health_goal}', [HealthGoalController::class, 'show'])->name('show');
        Route::get('/{law}/{year}/{health_goal}/ind/{indicator}/edit', [HealthGoalController::class, 'editInd'])->middleware('auth')->name('ind.edit');
        Route::put('/{law}/{year}/{health_goal}/ind/{indicator}', [HealthGoalController::class, 'updateInd'])->middleware('auth')->name('ind.update');
        Route::post('/{law}/{year}/{health_goal}/ind/{indicator}/import', [HealthGoalController::class, 'importIndValues'])->middleware('auth')->name('ind.import');
        Route::post('/{law}/{year}/{health_goal}/ind/{indicator}/saveFile', [HealthGoalController::class, 'saveFileInd'])->middleware('auth')->name('ind.saveFile');
        Route::post('/{law}/{year}/{health_goal}/ind/{indicator}/value/{value}', [HealthGoalController::class, 'storeIndValue'])->middleware('auth')->name('ind.value.store');
        Route::put('/{law}/{year}/{health_goal}/ind/{indicator}/value/{value}', [HealthGoalController::class, 'updateIndValue'])->middleware('auth')->name('ind.value.update');
    });

    Route::prefix('programming_aps')->as('programming_aps.')->group(function () {
        Route::get('/', [ProgramApsController::class, 'index'])->name('index');
        Route::get('/{year}/{commune}', [ProgramApsController::class, 'show'])->name('show');
    });

    Route::prefix('iaps')->as('iaps.')->group(function () {
        Route::get('/', [ApsController::class, 'index'])->name('index');
        Route::get('/{year}', [ApsController::class, 'list'])->name('list');
        Route::get('/{year}/{slug}/{establishment_type}', [ApsController::class, 'show'])->name('show');
    });

    Route::prefix('iiaaps')->as('iiaaps.')->group(function () {
        Route::get('/', [App\Http\Controllers\Indicators\IaapsController::class, 'index'])->name('index');
        Route::get('/{year}', [App\Http\Controllers\Indicators\IaapsController::class, 'list'])->name('list');
        Route::get('/{year}/{commune}', [App\Http\Controllers\Indicators\IaapsController::class, 'show'])->name('show');
    });

    Route::prefix('19813')->as('19813.')->group(function () {
        Route::get('/', function () {
            return view('indicators.19813.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            //Route::get('', [IndicatorController::class,'index_19813')->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'index'])->name('index');

            Route::get('/indicador1', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador1'])->name('indicador1');
            Route::get('/indicador2', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador2'])->name('indicador2');
            Route::get('/indicador3a', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador3a'])->name('indicador3a');
            Route::get('/indicador3b', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador3b'])->name('indicador3b');
            Route::get('/indicador3c', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador3c'])->name('indicador3c');
            Route::get('/indicador4a', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador4a'])->name('indicador4a');
            Route::get('/indicador4b', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador4b'])->name('indicador4b');
            Route::get('/indicador5', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador5'])->name('indicador5');
            Route::get('/indicador6', [App\Http\Controllers\Indicators\_2018\Indicator19813Controller::class, 'indicador6'])->name('indicador6');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/',           [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'index'])->name('index');
            Route::get('/indicador1', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador1'])->name('indicador1');
            Route::get('/indicador2', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador2'])->name('indicador2');
            Route::get('/indicador3a', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador3a'])->name('indicador3a');
            Route::get('/indicador3b', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador3b'])->name('indicador3b');
            Route::get('/indicador3c', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador3c'])->name('indicador3c');
            Route::get('/indicador4a', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador4a'])->name('indicador4a');
            Route::get('/indicador4b', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador4b'])->name('indicador4b');
            Route::get('/indicador5', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador5'])->name('indicador5');
            Route::get('/indicador6', [App\Http\Controllers\Indicators\_2019\Indicator19813Controller::class, 'indicador6'])->name('indicador6');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/',           [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'index'])->name('index');
            Route::get('/indicador1', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador1'])->name('indicador1');
            Route::get('/indicador2', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador2'])->name('indicador2');
            Route::get('/indicador3a', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador3a'])->name('indicador3a');
            Route::get('/indicador3b', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador3b'])->name('indicador3b');
            Route::get('/indicador3c', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador3c'])->name('indicador3c');
            Route::get('/indicador4a', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador4a'])->name('indicador4a');
            Route::get('/indicador4b', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador4b'])->name('indicador4b');
            Route::get('/indicador5', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador5'])->name('indicador5');
            Route::get('/indicador6', [App\Http\Controllers\Indicators\_2020\Indicator19813Controller::class, 'indicador6'])->name('indicador6');
        });
    });

    Route::prefix('19664')->as('19664.')->group(function () {
        Route::get('/', function () {
            return view('indicators.19664.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class, 'index'])->name('index');
            Route::get('/servicio', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class, 'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class, 'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2018\Indicator19664Controller::class, 'reyno'])->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class, 'index'])->name('index');
            Route::get('/servicio', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class, 'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class, 'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2019\Indicator19664Controller::class, 'reyno'])->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class, 'index'])->name('index');
            Route::get('/servicio', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class, 'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class, 'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\Indicator19664Controller::class, 'reyno'])->name('reyno');
        });
    });

    Route::prefix('18834')->as('18834.')->group(function () {
        Route::get('/', function () {
            return view('indicators.18834.index');
        })->name('index');

        Route::prefix('2018')->as('2018.')->group(function () {
            //Route::get('', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index_18834'])->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class, 'index'])->name('index');

            Route::get('/servicio', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class, 'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class, 'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class, 'reyno'])->name('reyno');
        });

        Route::prefix('2019')->as('2019.')->group(function () {
            //Route::get('', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index_18834'])->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class, 'index'])->name('index');

            Route::get('/servicio', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class, 'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class, 'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2019\Indicator18834Controller::class, 'reyno'])->name('reyno');
        });

        Route::prefix('2020')->as('2020.')->group(function () {
            //Route::get('', [App\Http\Controllers\Indicators\_2018\Indicator18834Controller::class,'index_18834'])->name('index');
            Route::get('/', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class, 'index'])->name('index');

            Route::get('/servicio', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class, 'servicio'])->name('servicio');
            Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class, 'hospital'])->name('hospital');
            Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\Indicator18834Controller::class, 'reyno'])->name('reyno');
        });
    });

    Route::prefix('program_aps')->as('program_aps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.program_aps.index');
        })->name('index');
        Route::prefix('2018')->as('2018.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class, 'create'])->name('create')->middleware('auth');
            Route::post('/', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class, 'store'])->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class, 'edit'])->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', [App\Http\Controllers\Indicators\_2018\ProgramApsValueController::class, 'update'])->name('update')->middleware('auth');
        });
        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class, 'create'])->name('create')->middleware('auth');
            Route::post('/', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class, 'store'])->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class, 'edit'])->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', [App\Http\Controllers\Indicators\_2019\ProgramApsValueController::class, 'update'])->name('update')->middleware('auth');
        });
        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', function () {
                return redirect()->route('indicators.program_aps.2020.index', 6);
            })->name('index');
            Route::get('/{commune}', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class, 'index'])->name('index');
            Route::get('/{commune}/create', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class, 'create'])->name('create')->middleware('auth');
            Route::post('/', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class, 'store'])->name('store')->middleware('auth');
            Route::get('/{glosa}/{commune}/edit', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class, 'edit'])->name('edit')->middleware('auth');
            Route::put('/{programApsValue}', [App\Http\Controllers\Indicators\_2020\ProgramApsValueController::class, 'update'])->name('update')->middleware('auth');
        });
    });

    Route::prefix('aps')->as('aps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.aps.index');
        })->name('index');
        Route::prefix('2020')->as('2020.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorAPSController::class, 'index'])->name('index');
            Route::get('/pmasama', [App\Http\Controllers\Indicators\_2020\IndicatorAPSController::class, 'pmasama'])->name('pmasama');

            Route::prefix('chcc')->as('chcc.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class, 'reyno'])->name('reyno');
                Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\IndicatorChccController::class, 'hospital'])->name('hospital');
            });

            Route::prefix('depsev')->as('depsev.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorDepsevController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorDepsevController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorDepsevController::class, 'reyno'])->name('reyno');
            });

            Route::prefix('saserep')->as('saserep.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class, 'reyno'])->name('reyno');
                Route::get('/hospital', [App\Http\Controllers\Indicators\_2020\IndicatorSaserepController::class, 'hospital'])->name('hospital');
            });

            Route::prefix('ges_odont')->as('ges_odont.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorGesOdontController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorGesOdontController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorGesOdontController::class, 'reyno'])->name('reyno');
            });

            Route::prefix('sembrando_sonrisas')->as('sembrando_sonrisas.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorSembrandoSonrisasController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorSembrandoSonrisasController::class, 'aps'])->name('aps');
                Route::get('/servicio', [App\Http\Controllers\Indicators\_2020\IndicatorSembrandoSonrisasController::class, 'servicio'])->name('servicio');
            });

            Route::prefix('mejoramiento_atencion_odontologica')->as('mejoramiento_atencion_odontologica.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorMejorAtenOdontController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorMejorAtenOdontController::class, 'aps'])->name('aps');
            });

            Route::prefix('odontologico_integral')->as('odontologico_integral.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorOdontIntegralController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorOdontIntegralController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorOdontIntegralController::class, 'reyno'])->name('reyno');
            });

            Route::prefix('resolutividad')->as('resolutividad.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorResolutividadController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorResolutividadController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorResolutividadController::class, 'reyno'])->name('reyno');
            });

            Route::prefix('pespi')->as('pespi.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorPespiController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorPespiController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorPespiController::class, 'reyno'])->name('reyno');
            });

            Route::prefix('equidad_rural')->as('equidad_rural.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorEquidadRuralController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorEquidadRuralController::class, 'aps'])->name('aps');
                // Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorEquidadRuralController::class,'reyno'])->name('reyno');
            });

            Route::prefix('respiratorio')->as('respiratorio.')->group(function () {
                Route::get('/', [App\Http\Controllers\Indicators\_2020\IndicatorRespiratorioController::class, 'index'])->name('index');

                Route::get('/aps', [App\Http\Controllers\Indicators\_2020\IndicatorRespiratorioController::class, 'aps'])->name('aps');
                Route::get('/reyno', [App\Http\Controllers\Indicators\_2020\IndicatorRespiratorioController::class, 'reyno'])->name('reyno');
            });
        });
    });

    Route::prefix('iaaps')->as('iaaps.')->group(function () {
        Route::get('/', function () {
            return view('indicators.iaaps.index');
        })
            ->name('index');

        Route::prefix('2019')->as('2019.')->group(function () {
            Route::get('/', [App\Http\Controllers\Indicators\IAAPS\_2019\IAAPSController::class, 'index'])
                ->name('index');

            /* Iquique 1101 */
            Route::get('/{comuna}', [App\Http\Controllers\Indicators\IAAPS\_2019\IAAPSController::class, 'show'])
                ->name('show');
        });
    });

    Route::prefix('rem')->as('rem.')->group(function () {
        Route::get('/{year}', [App\Http\Controllers\Indicators\RemController::class, 'list'])->name('list');
        Route::get('/{year}/{serie}', [App\Http\Controllers\Indicators\RemController::class, 'index'])->name('index');
        Route::get('/{year}/{serie}/{nserie}/{unique?}', [App\Http\Controllers\Indicators\RemController::class, 'show'])->name('show');
    });

    Route::prefix('rems')->as('rems.')->group(function () {
        Route::get('/', [App\Http\Controllers\Indicators\Rems\RemController::class, 'index'])->name('index');
        Route::get('2019', function () {
            return view('indicators.rem.2019.index');
        })->name('2019.index');
        Route::get('2020', function () {
            return view('indicators.rem.2020.index');
        })->name('2020.index');

        Route::get('/{year}/{serie}', [App\Http\Controllers\Indicators\Rems\RemController::class, 'index_serie_year'])->name('year.serie.index');

        Route::get('/{year}/{serie}/{nserie}', [App\Http\Controllers\Indicators\Rems\RemController::class, 'a01'])->name('year.serie.nserie.index');
        Route::post('/{year}/{serie}/{nserie}', [App\Http\Controllers\Indicators\Rems\RemController::class, 'show'])->name('year.serie.nserie.index');
    });
});


/* Middleware 'Drugs' hace que no se pueda tener acceso al módulo de drogas fuera de horario de oficina */
Route::prefix('drugs')->as('drugs.')->middleware('can:Drugs', 'auth', 'drugs')->group(function () {
    Route::resource('courts', App\Http\Controllers\Drugs\CourtController::class);
    Route::resource('police_units', App\Http\Controllers\Drugs\PoliceUnitController::class);
    Route::resource('substances', App\Http\Controllers\Drugs\SubstanceController::class);

    Route::get('users', [UserController::class, 'drugs'])->name('users');

    Route::get('receptions/report', [App\Http\Controllers\Drugs\ReceptionController::class, 'report'])->name('receptions.report');
    Route::get('receptions/{reception}/record', [App\Http\Controllers\Drugs\ReceptionController::class, 'showRecord'])->name('receptions.record');
    Route::get('receptions/{receptionitem}/edit_item', [App\Http\Controllers\Drugs\ReceptionController::class, 'editItem'])->name('receptions.edit_item');
    Route::put('receptions/{receptionitem}/update_item', [App\Http\Controllers\Drugs\ReceptionController::class, 'updateItem'])->name('receptions.update_item');
    Route::delete('receptions/{receptionitem}/destroy_item', [App\Http\Controllers\Drugs\ReceptionController::class, 'destroyItem'])->name('receptions.destroy_item');
    Route::put('receptions/{receptionitem}/store_result', [App\Http\Controllers\Drugs\ReceptionController::class, 'storeResult'])->name('receptions.store_result');
    Route::put('receptions/{receptionitem}/store_protocol', [App\Http\Controllers\Drugs\ReceptionController::class, 'storeProtocol'])->name('receptions.store_protocol');
    Route::get('receptions/protocols/{protocol}', [App\Http\Controllers\Drugs\ReceptionController::class, 'showProtocol'])->name('receptions.protocols.show');
    Route::post('receptions/{reception}/item', [App\Http\Controllers\Drugs\ReceptionController::class, 'storeItem'])->name('receptions.storeitem');
    Route::get('receptions/{reception}/doc_fiscal', [App\Http\Controllers\Drugs\ReceptionController::class, 'showDocFiscal'])->name('receptions.doc_fiscal');
    Route::get('receptions/{reception}/sample_to_isp', [App\Http\Controllers\Drugs\SampleToIspController::class, 'show'])->name('receptions.sample_to_isp.show');
    Route::post('receptions/{reception}/sample_to_isp', [App\Http\Controllers\Drugs\SampleToIspController::class, 'store'])->name('receptions.sample_to_isp.store');
    Route::get('receptions/{reception}/record_to_court', [App\Http\Controllers\Drugs\RecordToCourtController::class, 'show'])->name('receptions.record_to_court.show');
    Route::post('receptions/{reception}/record_to_court', [App\Http\Controllers\Drugs\RecordToCourtController::class, 'store'])->name('receptions.record_to_court.store');

    Route::resource('receptions', App\Http\Controllers\Drugs\ReceptionController::class);

    Route::resource('destructions', App\Http\Controllers\Drugs\DestructionController::class)->except(['create']);

    Route::get('rosters/analisis_to_admin', [App\Http\Controllers\Drugs\RosterAnalisisToAdminController::class, 'index'])->name('roster.analisis_to_admin.index');
    Route::get('rosters/analisis_to_admin/{id}', [App\Http\Controllers\Drugs\RosterAnalisisToAdminController::class, 'show'])->name('roster.analisis_to_admin.show');

    Route::get('precursors', App\Http\Livewire\Drugs\IndexActPrecursor::class)->name('precursors');
    Route::get('precursors/create', App\Http\Livewire\Drugs\CreateActPrecursor::class)->name('precursors.create');
    Route::get('precursors/{actPrecursor}/create', App\Http\Livewire\Drugs\EditActPrecursor::class)->name('precursors.edit');
    Route::get('precursors/{actPrecursor}/pdf', ActPrecursorController::class)->name('precursors.pdf');
});

Route::get('health_plan/{comuna}', [HealthPlanController::class, 'index'])->middleware('auth')->name('health_plan.index');
Route::get('health_plan/{comuna}/{file}', [HealthPlanController::class, 'download'])->middleware('auth')->name('health_plan.download');

Route::get('quality_aps', [QualityApsController::class, 'index'])->middleware('auth')->name('quality_aps.index');
Route::get('quality_aps/{file}', [QualityApsController::class, 'download'])->middleware('auth')->name('quality_aps.download');

// UNSPSC
Route::prefix('unspsc')->middleware(['auth', 'must.change.password'])->group(function () {

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
Route::prefix('warehouse')->as('warehouse.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::resource('stores', StoreController::class)->only(['index', 'create', 'edit'])
        ->middleware(['can:Store: warehouse manager']);
    Route::get('download-invoice/{invoice}', [ControlController::class, 'downloadInvoice'])->name('download-invoice');

    /** Para ver el acta de ingresos sin el middleware de store */
    Route::get('control/{control}/show', [ControlController::class, 'pdf'])->name('control.show');
    Route::get('control/{control}/showPdf', [ControlController::class, 'showPdf'])->name('control.showPdf');



    Route::prefix('store')->group(function () {
        Route::get('welcome', [StoreController::class, 'welcome'])->name('store.welcome');
        Route::prefix('{store}')->middleware('ensure.store')->group(function () {
            Route::get('active', [StoreController::class, 'activateStore'])->name('store.active');
            Route::get('users', [StoreController::class, 'users'])->name('stores.users');
            Route::get('report', [StoreController::class, 'report'])->name('store.report');
            Route::get('generate-reception', [ControlController::class, 'generateReception'])->name('generate-reception');
            Route::get('invoice-management', [ControlController::class, 'invoiceManage'])->name('invoice-management');

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

    Route::prefix('cenabast')->as('cenabast.')->group(function () {
        Route::get('index/{tray?}', CenabastIndex::class)->name('index');
        Route::post('/save-file/{dte}', [StoreController::class, 'saveFile'])->name('saveFile');
        Route::get('/download-file/{dte}', [StoreController::class, 'downloadFile'])->name('downloadFile');
        Route::get('/download-signed/{dte}/dte', [StoreController::class, 'downloadSigned'])->name('download.signed');
        Route::delete('/delete-file/{dte}', [StoreController::class, 'deleteFile'])->name('deleteFile');
        Route::get('/callback/{dte}/dte', [StoreController::class, 'callback'])->name('callback');
        Route::post('/bypass/{dte}', [StoreController::class, 'bypass'])->name('bypass');
    });

    Route::prefix('visation_contract_manager')->as('visation_contract_manager.')->group(function () {
        Route::get('/{tray?}', [VisationContractManager::class, 'index'])->name('index');
        Route::post('/accept/{control}', [VisationContractManager::class, 'accept'])->name('accept');
        Route::post('/reject/{control}', [VisationContractManager::class, 'reject'])->name('reject');
    });

});

Route::prefix('hotel_booking')->as('hotel_booking.')->middleware(['auth', 'must.change.password'])->group(function () {
    // Route::view('/index', 'hotel_booking.home')->name('index');
    Route::get('/', [HotelBookingController::class, 'index'])->name('index');
    Route::get('/search_booking', [HotelBookingController::class, 'search_booking'])->name('search_booking');
    Route::get('/my_bookings', [HotelBookingController::class, 'my_bookings'])->name('my_bookings');
    Route::delete('/{roomBooking}/booking_cancelation', [HotelBookingController::class, 'booking_cancelation'])->name('booking_cancelation');
    Route::view('/confirmation_page', 'hotel_booking.confirmation_page')->name('confirmation_page');
    Route::get('download/{file}',  [HotelBookingController::class, 'download'])->name('download');
    // Route::get('/confirmation_page/{roomBooking}', [HotelBookingController::class, 'confirmation_page'])->name('confirmation_page');
    // Route::get('/booking_cancelation/{roomBooking}', [HotelController::class, 'booking_cancelation'])->name('booking_cancelation');
    // Route::post('/booking_cancelation', [RoomController::class, 'booking_cancelation'])->name('booking_cancelation');

    Route::prefix('hotels')->as('hotels.')->middleware('auth')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/edit/{hotel}', [HotelController::class, 'edit'])->name('edit');
        Route::put('/update/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/store', [HotelController::class, 'store'])->name('store');
        Route::delete('/{hotel}/destroy', [HotelController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('rooms')->as('rooms.')->middleware('auth')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('edit');
        Route::put('/update/{room}', [RoomController::class, 'update'])->name('update');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/store', [RoomController::class, 'store'])->name('store');
        Route::delete('/{room}/destroy', [RoomController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('room_booking_configuration')->as('room_booking_configuration.')->middleware('auth')->group(function () {
        Route::get('/', [RoomBookingConfigurationController::class, 'index'])->name('index');
    });

    Route::prefix('services')->as('services.')->middleware('auth')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/edit/{service}', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/update/{service}', [ServiceController::class, 'update'])->name('update');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/store', [ServiceController::class, 'store'])->name('store');
        Route::delete('/{service}/destroy', [ServiceController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('prof_agenda')->as('prof_agenda.')->middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('prof_agenda.home');
    })->name('home');

    Route::prefix('proposals')->as('proposals.')->middleware(['auth'])->group(function () {
        Route::get('/', [ProposalController::class, 'index'])->name('index');
        Route::get('/edit/{proposal}', [ProposalController::class, 'edit'])->name('edit');
        Route::put('/update/{proposal}', [ProposalController::class, 'update'])->name('update');
        Route::get('/create', [ProposalController::class, 'create'])->name('create');
        Route::post('/store', [ProposalController::class, 'store'])->name('store');
        Route::delete('/{proposal}/destroy', [ProposalController::class, 'destroy'])->name('destroy');

        Route::get('/open_calendar', [ProposalController::class, 'open_calendar'])->name('open_calendar');
    });

    Route::prefix('agenda')->as('agenda.')->middleware(['auth'])->group(function () {
        Route::get('/', [AgendaController::class, 'index'])->name('index');
        // Route::get('/edit/{proposal}', [ProposalController::class, 'edit'])->name('edit');
        // Route::put('/update/{proposal}', [ProposalController::class, 'update'])->name('update');
        // Route::get('/create', [ProposalController::class, 'create'])->name('create');
        // Route::post('/store', [ProposalController::class, 'store'])->name('store');
        // Route::delete('/{proposal}/destroy', [ProposalController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('open_hour')->as('open_hour.')->middleware(['auth'])->group(function () {
        Route::get('/', [OpenHourController::class, 'index'])->name('index');
        // Route::get('/', [OpenHourController::class, 'index'])->name('index');
        // Route::get('/edit/{proposal}', [OpenHourController::class, 'edit'])->name('edit');
        // Route::put('/update/{proposal}', [OpenHourController::class, 'update'])->name('update');
        // Route::get('/create', [OpenHourController::class, 'create'])->name('create');
        Route::post('/store', [OpenHourController::class, 'store'])->name('store');
        Route::post('/delete_reservation', [OpenHourController::class, 'delete_reservation'])->name('delete_reservation');
        Route::post('/assistance_confirmation', [OpenHourController::class, 'assistance_confirmation'])->name('assistance_confirmation');
        Route::post('/absence_confirmation', [OpenHourController::class, 'absence_confirmation'])->name('absence_confirmation');
        Route::post('/destroy', [OpenHourController::class, 'destroy'])->name('destroy');
        Route::get('/change_hour/{id}/{start_date}', [OpenHourController::class, 'change_hour'])->name('change_hour');
        Route::post('/block', [OpenHourController::class, 'block'])->name('block');
        Route::post('/unblock', [OpenHourController::class, 'unblock'])->name('unblock');
        Route::post('/saveBlock', [OpenHourController::class, 'saveBlock'])->name('saveBlock');
        Route::post('/deleteBlocks', [OpenHourController::class, 'deleteBlocks'])->name('deleteBlocks');
        // Route::delete('/{openHour}/delete_reservation', [OpenHourController::class, 'delete_reservation'])->name('delete_reservation');
    });

    Route::prefix('activity_types')->as('activity_types.')->middleware(['auth'])->group(function () {
        Route::get('/', [ActivityTypeController::class, 'index'])->name('index');
        Route::get('/edit/{activityType}', [ActivityTypeController::class, 'edit'])->name('edit');
        Route::put('/update/{activityType}', [ActivityTypeController::class, 'update'])->name('update');
        Route::get('/create', [ActivityTypeController::class, 'create'])->name('create');
        Route::post('/store', [ActivityTypeController::class, 'store'])->name('store');
        Route::delete('/{activityType}/destroy', [ActivityTypeController::class, 'destroy'])->name('destroy');
    });


});

// Inventories
Route::prefix('inventories')->as('inventories.')->middleware(['auth', 'must.change.password'])->group(function () {
    /** Ruta para poder ver la hoja de inventario sin edición  */
    Route::get('number/{number}', InventoryShow::class)->name('show');

    Route::prefix('establishment/{establishment}')->group(function () {
        Route::get('/', InventoryIndex::class)->name('index')
            ->middleware(['can:Inventory: index']);
        Route::get('last-receptions', InventoryLastReceptions::class)->name('last-receptions')
            ->middleware(['can:Inventory: last receptions']);
        Route::get('pending-inventory', InventoryPending::class)->name('pending-inventory')
            ->middleware(['can:Inventory: pending inventory']);
        Route::get('/inventory/{inventory}/edit', InventoryEdit::class)->name('edit')
            ->middleware(['can:Inventory: edit']);
        Route::get('places', InventoryMaintainerPlaces::class)->name('places')
            ->middleware(['can:Inventory: place maintainer']);

        Route::get('/manage-users', InventoryManageUsers::class)->name('users.manager')->middleware(['can:Inventory: manager']);

        Route::get('/upload-excel', InventoryUploadExcel::class)->name('upload-excel');
    });

    Route::get('pending-movements', PendingMovements::class)->name('pending-movements');
    Route::get('assigned-products', AssignedProducts::class)->name('assigned-products');
    Route::get('movement/{movement}/check-transfer', CheckTransfer::class)->name('check-transfer')
        ->middleware('ensure.movement');
    Route::get('{inventory}/create-transfer', CreateTransfer::class)->name('create-transfer')
        ->middleware('ensure.inventory');
    Route::get('register', RegisterInventory::class)->name('register');

    Route::get('/manager', InventoryManager::class)->name('manager')->middleware(['can:Inventory: manager']);
});
/* Bodega de Farmacia */
Route::prefix('pharmacies')->as('pharmacies.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [App\Http\Controllers\Pharmacies\PharmacyController::class, 'index'])->name('index');
    Route::get('admin_view', [App\Http\Controllers\Pharmacies\PharmacyController::class, 'admin_view'])->name('admin_view');
    Route::get('pharmacy_users', [App\Http\Controllers\Pharmacies\PharmacyController::class, 'pharmacy_users'])->name('pharmacy_users');
    Route::post('user_asign_store', [PharmacyController::class, 'user_asign_store'])->name('user_asign_store');
    Route::delete('/{pharmacy}/{user}/user_asign_destroy', [PharmacyController::class, 'user_asign_destroy'])->name('user_asign_destroy');


    Route::resource('establishments', App\Http\Controllers\Pharmacies\EstablishmentController::class);
    Route::resource('programs', App\Http\Controllers\Pharmacies\ProgramController::class);
    Route::resource('suppliers', App\Http\Controllers\Pharmacies\SupplierController::class);

    Route::prefix('products')->as('products.')->middleware('auth')->group(function () {
        Route::resource('receiving', App\Http\Controllers\Pharmacies\ReceivingController::class);
        Route::resource('receiving_item', App\Http\Controllers\Pharmacies\ReceivingItemController::class);
        Route::get('receiving/record/{receiving}', [App\Http\Controllers\Pharmacies\ReceivingController::class, 'record'])->name('receiving.record');
        Route::get('dispatch/product/due_date/{product_id?}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'getFromProduct_due_date'])->name('dispatch.product.due_date')->middleware('auth');
        Route::get('dispatch/product/batch/{product_id?}/{due_date?}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'getFromProduct_batch'])->name('dispatch.product.batch')->middleware('auth');
        Route::get('dispatch/product/count/{product_id?}/{due_date?}/{batch?}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'getFromProduct_count'])->name('dispatch.product.count')->middleware('auth');
        Route::get('/exportExcel', [App\Http\Controllers\Pharmacies\DispatchController::class, 'exportExcel'])->name('exportExcel')->middleware('auth');
        Route::get('dispatch/sendEmailValidation/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'sendEmailValidation'])->name('dispatch.sendEmailValidation')->middleware('auth');

        Route::resource('dispatch', App\Http\Controllers\Pharmacies\DispatchController::class);
        Route::resource('dispatch_item', App\Http\Controllers\Pharmacies\DispatchItemController::class);
        Route::get('dispatch/record/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'record'])->name('dispatch.record');
        Route::get('dispatch/sendC19/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'sendC19'])->name('dispatch.sendC19');
        Route::get('dispatch/deleteC19/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'deleteC19'])->name('dispatch.deleteC19');
        Route::post('dispatch/{dispatch}/file', [App\Http\Controllers\Pharmacies\DispatchController::class, 'storeFile'])->name('dispatch.storeFile');
        Route::get('dispatch/{dispatch}/file', [App\Http\Controllers\Pharmacies\DispatchController::class, 'openFile'])->name('dispatch.openFile');
        Route::get('dispatch/storePrivateVerification/{dispatch}', [App\Http\Controllers\Pharmacies\DispatchController::class, 'storePrivateVerification'])->name('dispatch.storePrivateVerification');

        Route::resource('purchase', App\Http\Controllers\Pharmacies\PurchaseController::class);
        Route::resource('purchase_item', App\Http\Controllers\Pharmacies\PurchaseItemController::class);
        Route::get('purchase/sendForSignature/{purchase}/', [App\Http\Controllers\Pharmacies\PurchaseController::class, 'sendForSignature'])->name('purchase.sendForSignature');
        Route::get('purchase/record/{purchase}', [App\Http\Controllers\Pharmacies\PurchaseController::class, 'record'])->name('purchase.record');
        Route::get('purchase/record-pdf/{purchase}', [App\Http\Controllers\Pharmacies\PurchaseController::class, 'recordPdf'])->name('purchase.record_pdf');
        Route::get('/callback-firma-record/{message}/{modelId}/{signaturesFile?}', [PurchaseController::class, 'callbackFirmaRecord'])->name('callbackFirmaRecord');
        Route::get('/signed-record-pdf/{purchase}', [PurchaseController::class, 'signedRecordPdf'])->name('signed_record_pdf');

        Route::resource('transfer', App\Http\Controllers\Pharmacies\TransferController::class);
        Route::get('transfer/{establishment}/auth', [App\Http\Controllers\Pharmacies\TransferController::class, 'auth'])->name('transfer.auth');
        Route::resource('deliver', App\Http\Controllers\Pharmacies\DeliverController::class);
        Route::put('deliver/{deliver}/confirm', [App\Http\Controllers\Pharmacies\DeliverController::class, 'confirm'])->name('deliver.confirm');
        Route::put('deliver/{deliver}/saveDocId', [App\Http\Controllers\Pharmacies\DeliverController::class, 'saveDocId'])->name('deliver.saveDocId');
        Route::delete('deliver/{deliver}/restore', [App\Http\Controllers\Pharmacies\DeliverController::class, 'restore'])->name('deliver.restore');
    });
    Route::resource('products', App\Http\Controllers\Pharmacies\ProductController::class);

    Route::prefix('reports')->as('reports.')->middleware('auth')->group(function () {
        Route::get('bincard', [App\Http\Controllers\Pharmacies\ProductController::class, 'repBincard'])->name('bincard');
        Route::get('purchase_report', [App\Http\Controllers\Pharmacies\ProductController::class, 'repPurchases'])->name('purchase_report');
        Route::get('informe_movimientos', [App\Http\Controllers\Pharmacies\ProductController::class, 'repInformeMovimientos'])->name('informe_movimientos');
        Route::get('product_last_prices', [App\Http\Controllers\Pharmacies\ProductController::class, 'repProductLastPrices'])->name('product_last_prices');
        Route::get('consume_history', [App\Http\Controllers\Pharmacies\ProductController::class, 'repConsumeHistory'])->name('consume_history');

        Route::get('products', [App\Http\Controllers\Pharmacies\ProductController::class, 'repProduct'])->name('products');
    });
});

/* Finanzas */
Route::prefix('finance')->as('finance.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('dtes', IndexDtes::class)->name('dtes.index');
    Route::get('dte/{dte}/store', [DteController::class, 'store'])->name('dtes.confirmation.store');
    Route::get('dte/{dte}/confirmation-signature-file', [DteController::class, 'pdf'])->name('dtes.confirmation.pdf');

    Route::get('/{dte}/download', [DteController::class, 'downloadManualDteFile'])->name('dtes.downloadManualDteFile');

    Route::get('dtes/upload', UploadDtes::class)->name('dtes.upload');
    Route::get('dtes/{dte}/confirmation', DteConfirmation::class)->name('dtes.confirmation');
    Route::prefix('payments')->as('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/own', [PaymentController::class, 'indexOwn'])->name('own');
        Route::get('/review', [PaymentController::class, 'review'])->name('review');
        Route::get('/{dte}/send-to-ready-inbox', [PaymentController::class, 'sendToReadyInbox'])->name('sendToReadyInbox');
        Route::get('/ready', [PaymentController::class, 'ready'])->name('ready');
        Route::put('/{dte}/return-to-review', [PaymentController::class, 'returnToReview'])->name('returnToReview');
        Route::get('/rejected', [PaymentController::class, 'rejected'])->name('rejected');
        Route::put('/{dte}/update', [PaymentController::class, 'update'])->name('update');
    });

    Route::prefix('purchase-orders')->as('purchase-orders.')->group(function () {
        Route::get('/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('show');
        Route::get('/by-code/{po_code}', [PurchaseOrderController::class, 'showByCode'])->name('showByCode');
    });
});

/* */
Route::prefix('purchase_plan')->as('purchase_plan.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/own_index', [PurchasePlanController::class, 'own_index'])->name('own_index');
    Route::get('/all_index', [PurchasePlanController::class, 'all_index'])->name('all_index');
    Route::get('/create', [PurchasePlanController::class, 'create'])->name('create');
    Route::get('/{purchasePlan}/show', [PurchasePlanController::class, 'show'])->name('show');
    Route::get('/{purchase_plan_id}/show_approval', [PurchasePlanController::class, 'show_approval'])->name('show_approval');
    Route::get('/{purchasePlan}/edit', [PurchasePlanController::class, 'edit'])->name('edit');
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

Route::prefix('request_forms')->as('request_forms.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/info/info_circular_n75_2023', function () {
        return Storage::disk('gcs')->response('ionline/request_forms/info/info_circular_n75_2023.pdf');
    })->name('info_circular_n75_2023');

    Route::get('/my_forms', [RequestFormController::class, 'my_forms'])->name('my_forms');
    Route::get('/all_forms', [RequestFormController::class, 'all_forms'])->name('all_forms');
    Route::get('/pending_forms', [RequestFormController::class, 'pending_forms'])->name('pending_forms');
    Route::get('/contract_manager_forms', [RequestFormController::class, 'contract_manager_forms'])->name('contract_manager_forms');
    Route::get('/create', [RequestFormController::class, 'create'])->name('create');
    Route::post('/{requestForm}/create_provision', [RequestFormController::class, 'create_provision'])->name('create_provision');
    Route::get('/{requestForm}/sign/{eventType}', [RequestFormController::class, 'sign'])->name('sign');
    Route::get('/callback-sign-request-form/{message}/{modelId}/{signaturesFile?}', [RequestFormController::class, 'callbackSign'])->name('callbackSign');
    Route::get('/callback-sign-new-budget/{message}/{modelId}/{signaturesFile?}', [RequestFormController::class, 'callbackSignNewBudget'])->name('callbackSignNewBudget');
    Route::get('/signed-request-form-pdf/{requestForm}/{original}', [RequestFormController::class, 'signedRequestFormPDF'])->name('signedRequestFormPDF');
    Route::get('/signed-old-request-form-pdf/{oldSignatureFile}', [RequestFormController::class, 'signedOldRequestFormPDF'])->name('signedOldRequestFormPDF');
    Route::get('/request_form_comments', [RequestFormController::class, 'request_form_comments'])->name('request_form_comments');
    Route::get('/export', [RequestFormController::class, 'export'])->name('export');
    Route::get('/{requestForm}/copy', [RequestFormController::class, 'copy'])->name('copy');
    Route::get('/{requestForm}/rollback', [RequestFormController::class, 'rollback'])->name('rollback');

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
        Route::delete('/{detail}/release_item', [PurchasingProcessController::class, 'release_item'])->name('release_item');
        Route::delete('/{detail}/release_all_items', [PurchasingProcessController::class, 'release_all_items'])->name('release_all_items');
        Route::get('/mercado-publico-api/{type}/{code}', function ($type, $code) {
            return MercadoPublico::getTender($code, $type);
        });
    });

    Route::prefix('reports')->as('reports.')->middleware('auth')->group(function () {
        Route::get('/show_form_items', [RequestFormController::class, 'show_form_items'])->name('show_form_items');
        Route::get('/show_form_items_export', [RequestFormController::class, 'show_form_items_export'])->name('show_form_items_export');
        Route::get('/show_amounts_by_program', [RequestFormController::class, 'show_amounts_by_program'])->name('show_amounts_by_program');
        Route::get('/show_globals_amounts', ReportGlobalBudget::class)->name('show_globals_amounts');
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
});

/** Fin rutas Request Form */

Route::prefix('allowances')->as('allowances.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [AllowanceController::class, 'index'])->name('index');
    Route::get('all_index', [AllowanceController::class, 'all_index'])->name('all_index')->middleware('permission:Allowances: all');
    Route::get('sign_index', [AllowanceController::class, 'sign_index'])->name('sign_index');
    Route::get('create', [AllowanceController::class, 'create'])->name('create');
    Route::post('store', [AllowanceController::class, 'store'])->name('store');
    Route::get('{allowance}/edit', [AllowanceController::class, 'edit'])->name('edit');
    Route::put('{allowance}/update', [AllowanceController::class, 'update'])->name('update');
    Route::get('{allowance}/show', [AllowanceController::class, 'show'])->name('show');
    Route::get('/show_file/{allowance}', [AllowanceController::class, 'show_file'])->name('show_file');

    Route::prefix('files')->as('files.')->group(function () {
        Route::get('/show/{allowanceFile}', [AllowanceFileController::class, 'show'])->name('show');
    });

    Route::prefix('sign')->as('sign.')->group(function () {
        Route::put('{allowanceSign}/{status}/{allowance}/update', [AllowanceSignController::class, 'update'])->name('update');
        Route::get('/{allowance}/create_view_document', [AllowanceSignController::class, 'create_view_document'])->name('create_view_document');
        Route::get('/{allowance}/create_form_document', [AllowanceSignController::class, 'create_form_document'])->name('create_form_document');
        Route::get('/callback-sign-allowance/{message}/{modelId}/{signaturesFile?}', [AllowanceSignController::class, 'callbackSign'])->name('callbackSign');
        // Route::get('/callback-sign-request-form/{message}/{modelId}/{signaturesFile?}', [RequestFormController::class, 'callbackSign'])->name('callbackSign');
    });

    Route::prefix('reports')->as('reports.')->group(function () {
        Route::get('/create_by_dates', [AllowanceController::class, 'create_by_dates'])->name('create_by_dates');
        Route::get('/create_by_dates_excel/{from}/{to}', [AllowanceController::class, 'create_by_dates_excel'])->name('create_by_dates_excel');
    });

    Route::get('import', [AllowanceController::class, 'import'])->name('import');
});

/** Módulo de horas para vacunas. ya no se usa */
// Route::get('/yomevacuno',[VaccinationController::class,'welcome']);

// Route::prefix('vaccination')->as('vaccination.')->group(function () {
//     Route::get('/welcome',[VaccinationController::class,'welcome'])->name('welcome');
//     Route::get('/login/{access_token}',[VaccinationController::class,'login'])->name('login');
//     Route::get('/',[VaccinationController::class,'index'])->name('index')->middleware('auth');
//     Route::get('/create',[VaccinationController::class,'create'])->name('create')->middleware('auth');
//     Route::post('/',[VaccinationController::class,'store'])->name('store')->middleware('auth');
//     Route::post('/show',[VaccinationController::class,'show'])->name('show');
//     Route::get('/{vaccination}/edit',[VaccinationController::class,'edit'])->name('edit')->middleware('auth');
//     Route::put('/{vaccination}',[VaccinationController::class,'update'])->name('update')->middleware('auth');
//     Route::get('/report',[VaccinationController::class,'report'])->name('report')->middleware('auth');
//     Route::get('/export',[VaccinationController::class,'export'])->name('export')->middleware('auth');
//     Route::put('/vaccinate/{vaccination}/{dose}',[VaccinationController::class,'vaccinate'])->name('vaccinate')->middleware('auth');
//     Route::get('/vaccinate/remove-booking/{vaccination}',[VaccinationController::class,'removeBooking'])->name('removeBooking')->middleware('auth');
//     Route::get('/card/{vaccination}',[VaccinationController::class,'card'])->name('card')->middleware('auth');
//     Route::get('/slots',[VaccinationController::class,'slots'])->name('slots')->middleware('auth');
//     Route::put('/arrival/{vaccination}/{reverse?}',[VaccinationController::class,'arrival'])->name('arrival')->middleware('auth');
//     Route::put('/dome/{vaccination}/{reverse?}',[VaccinationController::class,'dome'])->name('dome')->middleware('auth');
// });

Route::prefix('mammography')->as('mammography.')->group(function () {
    Route::get('/welcome', [MammographyController::class, 'welcome'])->name('welcome');
    Route::get('/login/{access_token}', [MammographyController::class, 'login'])->name('login');
    Route::get('/', [MammographyController::class, 'index'])->name('index')->middleware('auth');
    Route::get('/schedule', [MammographyController::class, 'schedule'])->name('schedule')->middleware('auth');
    Route::get('/create', [MammographyController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/', [MammographyController::class, 'store'])->name('store')->middleware('auth');
    Route::post('/show', [MammographyController::class, 'show'])->name('show');
    Route::get('/{mammography}/edit', [MammographyController::class, 'edit'])->name('edit')->middleware('auth');
    Route::put('/{mammography}', [MammographyController::class, 'update'])->name('update')->middleware('auth');
    // Route::get('/report',[VaccinationController::class,'report'])->name('report')->middleware('auth');
    Route::get('/export', [MammographyController::class, 'export'])->name('export')->middleware('auth');
    // Route::put('/vaccinate/{vaccination}/{dose}',[VaccinationController::class,'vaccinate'])->name('vaccinate')->middleware('auth');
    // Route::get('/vaccinate/remove-booking/{vaccination}',[VaccinationController::class,'removeBooking'])->name('removeBooking')->middleware('auth');
    // Route::get('/card/{vaccination}',[VaccinationController::class,'card'])->name('card')->middleware('auth');
    Route::get('/slots', [MammographyController::class, 'slots'])->name('slots')->middleware('auth');
    // Route::put('/arrival/{vaccination}/{reverse?}',[VaccinationController::class,'arrival'])->name('arrival')->middleware('auth');
    // Route::put('/dome/{vaccination}/{reverse?}',[VaccinationController::class,'dome'])->name('dome')->middleware('auth');
});


Route::prefix('invoice')->as('invoice.')->group(function () {
    Route::get('/welcome', [InvoiceController::class, 'welcome'])->name('welcome');
    Route::get('/login/{access_token}', [InvoiceController::class, 'login'])->name('login');
    Route::post('/show', [InvoiceController::class, 'show'])->name('show');
});


Route::prefix('suitability')->as('suitability.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [SuitabilityController::class, 'indexOwn'])->name('own');
    Route::post('/emergency/{psirequest}', [SuitabilityController::class, 'emergency'])->name('emergency');
    Route::get('/report/all/request', [SuitabilityController::class, 'reportAllRequest'])->name('reportAllRequest');
    Route::get('/report', [SuitabilityController::class, 'report'])->name('report');
    Route::get('/reportsigned', [SuitabilityController::class, 'reportsigned'])->name('reportsigned');
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

    Route::post('/livewire/message/rrhh/change-shift-day-status', [\App\Http\Livewire\Rrhh\ChangeShiftDayStatus::class]);
    // Route::post('livewire/message/rrhh.change-shift-day-status', [\App\Livewire\Rrhh\ChangeShiftDayStatus::class]);+



});

/* Rutas de cargador de REM */
Route::prefix('rem')->as('rem.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserRemController::class, 'index'])->name('index');
        Route::get('/create', [UserRemController::class, 'create'])->name('create');
        Route::post('/store', [UserRemController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [UserRemController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('periods')->as('periods.')->middleware('auth')->group(function () {
        Route::get('/', [RemPeriodController::class, 'index'])->name('index');
        Route::get('/create', [RemPeriodController::class, 'create'])->name('create');
        Route::post('/store', [RemPeriodController::class, 'store'])->name('store');
        Route::delete('/{period}/destroy', [RemPeriodController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('series')->as('series.')->middleware('auth')->group(function () {
        Route::get('/', [RemSerieController::class, 'index'])->name('index');
        Route::get('/create', [RemSerieController::class, 'create'])->name('create');
        Route::post('/store', [RemSerieController::class, 'store'])->name('store');
        Route::delete('/{serie}/destroy', [RemSerieController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('periods_series')->as('periods_series.')->middleware('auth')->group(function () {
        Route::get('/', [RemPeriodSerieController::class, 'index'])->name('index');
        Route::get('/create', [RemPeriodSerieController::class, 'create'])->name('create');
        Route::post('/store', [RemPeriodSerieController::class, 'store'])->name('store');
    });
    Route::prefix('files')->as('files.')->middleware('auth')->group(function () {
        Route::get('/', [RemFileController::class, 'index'])->name('index');
        Route::post('/store', [RemFileController::class, 'store'])->name('store');
        Route::post('/autorizacion_store', [RemFileController::class, 'autorizacion_store'])->name('autorizacion_store');
        Route::get('/download/{remFile}', [RemFileController::class, 'download'])->name('download');
        Route::delete('/{remFile}/destroy', [RemFileController::class, 'destroy'])->name('destroy');
    });

    Route::get('/rem_original', [RemFileController::class, 'rem_original'])->name('files.rem_original');
    Route::get('/rem_correccion', [RemFileController::class, 'rem_correccion'])->name('files.rem_correccion');
});

/* Rutas de Módulo de Bienestar */
Route::prefix('welfare')->as('welfare.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [WelfareController::class, 'index'])->name('index');
    Route::get('/balances', [WelfareController::class, 'balances'])->name('balances');
    Route::get('/report', [WelfareController::class, 'report'])->name('report');
    Route::get('/export-balance', [WelfareController::class, 'exportBalance'])->name('exportBalance');


    Route::prefix('loans')->as('loans.')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('index');
        Route::post('/import', [LoanController::class, 'import'])->name('import');
    });

    Route::prefix('dosfile')->as('dosfile.')->group(function () {
        Route::get('/', [WelfareController::class, 'dosindex'])->name('index');
        Route::post('/import', [WelfareController::class, 'dosimport'])->name('import');
    });

    Route::prefix('amipass')->as('amipass.')->group(function () {
        Route::get('/mi-amipass', [AmipassController::class, 'miAmipass'])->name('mi-amipass');
        Route::get('/dashboard', [AmipassController::class, 'index'])->name('dashboard');
        Route::get('/question-my-index', [AmipassController::class, 'questionMyIndex'])->name('question-my-index');
        Route::get('/question-all-index', [AmipassController::class, 'questionAllIndex'])->name('question-all-index');
        Route::get('/question/create', [AmipassController::class, 'questionCreate'])->name('question-create');
        Route::post('/question/store', [AmipassController::class, 'questionStore'])->name('question-store');
        Route::get('/question/{id}/edit', [AmipassController::class, 'questionEdit'])->name('question-edit');
        Route::put('/question/{id}', [AmipassController::class, 'questionUpdate'])->name('question-update');
        Route::get('/question/{id}', [AmipassController::class, 'questionShow'])->name('question-show');

        // Route::post('/import', [WelfareController::class, 'dosimport'])->name('import');
        Route::view('/upload', 'welfare.amipass.index')->name('upload');
        Route::get('/new-beneficiary-request', NewBeneficiaryRequest::class)->name('new-beneficiary-request');
        Route::get('/requests-manager', RequestMgr::class)->name('requests-manager');

        Route::get('/report-by-dates', ReportByDates::class)->name('report-by-dates');
        Route::prefix('value')->as('value.')->group(function () {
            Route::get('/', [AmipassController::class, 'indexValue'])->name('indexValue');
            Route::get('reportByDates', [AmipassController::class, 'reportByDates'])->name('reportByDates');
            Route::get('/create', [AmipassController::class, 'createValue'])->name('createValue');
            Route::post('/store', [AmipassController::class, 'storeValue'])->name('storeValue');
        });
    });
});


/* Rutas de Módulo de Sumario*/
Route::prefix('summary')->as('summary.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/', [SummaryController::class, 'index'])->name('index');
    Route::get('/create', [SummaryController::class, 'create'])->name('create');
    Route::post('/store', [SummaryController::class, 'store'])->name('store');
    Route::get('/edit/{summary}', [SummaryController::class, 'edit'])->name('edit');

    Route::prefix('{summary}/event')->as('event.')->group(function () {
        Route::post('/store/{event?}', [SummaryEventController::class, 'store'])->name('store');
        Route::put('/{event}', [SummaryEventController::class, 'update'])->name('update');
    });

    Route::prefix('files')->as('files.')->group(function () {
        Route::post('/store', [SummaryFileController::class, 'store'])->name('store');
        Route::get('/{file}/delete', [SummaryFileController::class, 'deleteFile'])->name('delete');
        Route::get('/{file}/download', [SummaryFileController::class, 'downloadFile'])->name('download');
    });

    Route::prefix('event-types')->as('event-types.')->group(function () {
        Route::get('/', [SummaryEventTypeController::class, 'index'])->name('index');
        Route::get('/create', [SummaryEventTypeController::class, 'create'])->name('create');
        Route::post('/store', [SummaryEventTypeController::class, 'store'])->name('store');
        Route::get('/{eventType}/edit', [SummaryEventTypeController::class, 'edit'])->name('edit');
        Route::put('/{eventType}/update', [SummaryEventTypeController::class, 'update'])->name('update');
        Route::delete('/{eventType}/destroy', [SummaryEventTypeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('links')->as('links.')->group(function () {
        Route::get('/', [LinkController::class, 'index'])->name('index');
        Route::get('/create', [LinkController::class, 'create'])->name('create');
        Route::post('/store', [LinkController::class, 'store'])->name('store');
    });


    Route::prefix('templates')->as('templates.')->group(function () {
        Route::get('/', [SummaryTemplateController::class, 'index'])->name('index');
        Route::get('/create', [SummaryTemplateController::class, 'create'])->name('create');
        Route::post('/store', [SummaryTemplateController::class, 'store'])->name('store');
        Route::get('/{file}/download', [SummaryTemplateController::class, 'download'])->name('download');
        Route::get('/{summary}/{template}', ShowTemplate::class)->name('show');
        //Route::get('/create', [LinkController::class, 'create'])->name('create');
        //Route::post('/store', [LinkController::class, 'store'])->name('store');
    });
});


/* Rutas de Módulo de Lobby*/
// Inicio Módulo Lobby
Route::prefix('lobby')->as('lobby.')->middleware(['auth', 'must.change.password'])->group(function () {
    Route::prefix('meeting')->as('meeting.')->group(function () {
        Route::get('/', [MeetingController::class, 'index'])->name('index');
        Route::get('/create', [MeetingController::class, 'create'])->name('create');
        Route::post('/store', [MeetingController::class, 'store'])->name('store');
        Route::get('/edit/{meeting}', [MeetingController::class, 'edit'])->name('edit');
        Route::put('/update/{meeting}', [MeetingController::class, 'update'])->name('update');
    });
});

/**
 * Rutas de Modulo Sign
 */
Route::middleware(['auth', 'must.change.password'])->group(function () {
    Route::get('/position-document-number', [SignSignatureController::class, 'positionDocumentNumber']);
});

Route::prefix('v2/documents')->as('v2.documents.')->middleware('auth')->group(function () {
    Route::get('/test', [SignSignatureController::class, 'test'])->name('test');

    Route::get('/{signature}/file', [SignSignatureController::class, 'showFile'])->name('show.file');
    Route::get('/{signature}/signed-file', [SignSignatureController::class, 'showSignedFile'])->name('show.signed.file');

    Route::prefix('signatures')->as('signatures.')->group(function () {
        Route::get('/create', RequestSignature::class)->name('create');
        Route::get('/index', SignatureIndex::class)->name('index');
        Route::get('/signature/{signature}/user/{user}/filename/{filename}/update', [SignSignatureController::class, 'update'])->name('update');
    });
});

/** Rutas de solicitudes de Rayen */
Route::prefix('his')->as('his.')->middleware('auth')->group(function () {
    Route::prefix('modification-request')->as('modification-request.')->group(function () {
        Route::get('/', ModificationRequestIndex::class)->name('index');
        Route::get('/new', NewModification::class)->name('new');
        Route::get('/mgr', ModificationMgr::class)->name('mgr');
        Route::get('/{modification_request_id}/show', [ModificationRequestController::class,'show'])->name('show');
        Route::view('/parameters', 'his.parameters')->name('parameters');

        Route::prefix('files')->as('files.')->group(function () {
            // Route::post('/store', [SummaryFileController::class, 'store'])->name('store');
            // Route::get('/{file}/delete', [SummaryFileController::class, 'deleteFile'])->name('delete');
            Route::get('/{file}/download', [ModificationRequestController::class, 'download'])->name('download');
        });

    });
});


/** RUTAS PARA EXTERNAL  */
Route::group(['middleware' => 'auth:external'], function () {
    Route::view('/external', 'external')->name('external');
    //Route::view('/external', 'external')->name('external');
    Route::prefix('idoneidad')->as('idoneidad.')->group(function () {
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

    Route::prefix('replacement_staff')->as('replacement_staff.')->group(function () {
        Route::get('/create', [ReplacementStaffController::class, 'create'])->name('create');
        Route::post('/store', [ReplacementStaffController::class, 'store'])->name('store');
        Route::get('/{replacement_staff}/edit', [ReplacementStaffController::class, 'edit'])->name('edit');
        Route::put('/{replacement_staff}/update', [ReplacementStaffController::class, 'update'])->name('update');
        Route::get('/show_file/{replacement_staff}', [ReplacementStaffController::class, 'show_file'])->name('show_file');
        Route::get('/download/{replacement_staff}', [ReplacementStaffController::class, 'download'])->name('download');
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::post('/{replacementStaff}/store', [ProfileController::class, 'store'])->name('store');
            Route::get('/download/{profile}', [ProfileController::class, 'download'])->name('download');
            Route::get('/show_file/{profile}', [ProfileController::class, 'show_file'])->name('show_file');
            Route::delete('{profile}/destroy', [ProfileController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('training')->name('training.')->group(function () {
            Route::post('/{replacementStaff}/store', [TrainingController::class, 'store'])->name('store');
            Route::get('/download/{training}', [TrainingController::class, 'download'])->name('download');
            Route::get('/show_file/{training}', [TrainingController::class, 'show_file'])->name('show_file');
            Route::delete('{training}/destroy', [TrainingController::class, 'destroy'])->name('destroy');
        });
    });
});




/** Test Routes */
Route::view('/some', 'some');

Route::prefix('test')->as('test.')->group(function () {
    Route::get('/ous', [TestController::class, 'ous']);

    Route::get('/loop-livewire', [TestController::class, 'loopLivewire']);
    // Route::get('/dev/get-ip',[TestController::class,'getIp']);
    // Route::get('/log',[TestController::class,'log']);
    Route::get('/test-mercado-publico-api/{date}', [TestController::class, 'getMercadoPublicoTender']);
    // Route::get('/info',[TestController::class,'info']);
    Route::get('/job', [TestController::class, 'job'])->middleware('auth');

    /* Maqueteo calendario */
    Route::get('/calendar', function () {
        return view('calendar');
    });

    /* Maqueta urgencias para wordpress */
    Route::get('/urgency', function () {
        return view('test.urgency');
    });

    /** Usuarios del servicio */
    Route::get('/usuarios', function () {
        echo "<pre>";
        $users = User::with('organizationalUnit')->whereRelation('organizationalUnit','establishment_id', 38)->get();
        foreach($users as $user) {
            echo $user->id.';'.$user->dv.';'.$user->shortName.';'.$user->email.';'.optional($user->organizationalUnit)->name."\n";
        }
        echo "</pre>";
    })->middleware('auth');

    Route::get('/teams', [TestController::class, 'SendCardToTeams'])->middleware('auth');
});


// Maqueta para nueva vista honorarios y contratos
Route::get('/maquetas/honorarios', function () {
    return view('maquetas.honorarios');
})->name('maquetas.honorarios');

Route::get('/maquetas/menu', function () {
    return view('maquetas.menu');
})->name('maquetas.menu');

Route::get('/maquetas/vista', function () {
    return view('maquetas.vista');
})->name('maquetas.vista');



/* Registro asistencia cena SST 2023 */
use App\Http\Controllers\Attendances\PeopleController;

Route::get('/attendances/', function () {
    return view('attendances.principal');
});
Route::post('/attendances/login', [PeopleController::class, 'customLogin'])->name('attendances.login');

Route::get('/attendances/unregistered', function () {
    return view('attendances.unregistered');
})->name('attendances.unregistered');

Route::get('/attendances/main', function() {
    return view('attendances.main');
})->name('attendances.main');

## OLVIDO CONTRASEÑA

Route::get('/forgot-password', [PasswordResetController::class, 'startPasswordReset'])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetPasswordToken'])->middleware('guest')->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->middleware('guest')->name('password.update');