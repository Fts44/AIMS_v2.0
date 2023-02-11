<?php

// =============================== Start of Global Controllers ===============================

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\OTPController as OTPController;
    use App\Http\Controllers\PopulateSelectController as PopulateSelect;

    Route::prefix('populate')->group(function(){
        // start address
            Route::get('province',[PopulateSelect::class, 'province'])->name('GetProvince');
            Route::get('municipality/{prov_code}', [PopulateSelect::class, 'municipality'])->name('GetMunicipality');
            Route::get('barangay/{mun_code}', [PopulateSelect::class, 'barangay'])->name('GetBarangay');
        // end address

        Route::get('gradelevel', [PopulateSelect::class, 'grade_level'])->name('GetGradeLevel');
        Route::get('department/{gl_id}',[PopulateSelect::class, 'department'])->name('GetDepartment');
        Route::get('program/{dept_id}',[PopulateSelect::class, 'program'])->name('GetProgram');
        Route::get('yearlevel/{gl_id}',[PopulateSelect::class, 'year_level'])->name('GetYearLevel');
        
        Route::get('religion', [PopulateSelect::class, 'religion'])->name('GetReligion');
        Route::get('covidvaccinationbrand', [PopulateSelect::class, 'covid_vaccination_brand'])->name('GetCovidVaccinationBrand');
    });
// =============================== End of Global Controllers =================================



// =============================== Start Authentication ======================================

    use App\Http\Controllers\Authentication\LoginController as LoginController;
    use App\Http\Controllers\Authentication\RegistrationController as RegistrationController;
    use App\Http\Controllers\Authentication\RecoverController as RecoverController;

    Route::get('logout', [LoginController::class, 'logout'])->name('Logout');
    Route::post('get_otp', [OTPController::class, 'compose_mail'])->name('SendOTP');

    Route::group(['prefix' => '/', 'middleware' => 'IsLoggedIn'],function(){
        // Login
        Route::get('', [LoginController::class, 'index'])->name('Login.Index');
        Route::post('login', [LoginController::class, 'login'])->name('Login.Create');

        // Registration
        Route::get('register', [RegistrationController::class, 'index'])->name('Registration.Index');
        Route::post('register/new', [RegistrationController::class, 'register'])->name('Register.Create');

        // Recover
        Route::get('recover', [RecoverController::class, 'index'])->name('Recover.Index');
        Route::post('recover/new', [RecoverController::class, 'recover'])->name('Recover.Create');
    });

// =============================== End Authentication ========================================


// =============================== Start Patient =============================================
    
    use App\Http\Controllers\Patient\Profile\PersonalDetailsController as PersonalDetailsController;
    use App\Http\Controllers\Patient\Profile\EmergencyContactController as EmergencyContactController;
    use App\Http\Controllers\Patient\Profile\MedicalHistoryController as MedicalHistoryController;
    use App\Http\Controllers\Patient\Profile\FamilyDetailsController as FamilyDetailsController;
    use App\Http\Controllers\Patient\Profile\AssessmentDiagnosisController as AssessmentDiagnosisController;

    use App\Http\Controllers\Patient\CovidVaccinationInsuranceController as CovidVaccinationInsuranceController;

    use App\Http\Controllers\Patient\Documents\UploadsController as DocumentUploadController;
    use App\Http\Controllers\Patient\Documents\PrescriptionController as DocumentPrescriptionController;
    
    use App\Http\Controllers\Patient\AttendanceController as AttendanceController;

    Route::group(['prefix' => 'pt'], function(){

        Route::get('default_route', function(){
            return redirect()->route('Patient.Profile.PersonalDetails.Index');
        })->name('patient');

        Route::prefix('profile')->group(function(){
            Route::get('personal_details', [PersonalDetailsController::class, 'index'])->name('Patient.Profile.PersonalDetails.Index');
            Route::post('personal_details/update', [PersonalDetailsController::class, 'update'])->name('Patient.Profile.PersonalDetails.Update');

            Route::get('emergency_contact', [EmergencyContactController::class, 'index'])->name('Patient.Profile.EmergencyContact.Index');
            Route::post('emergency_contact/update', [EmergencyContactController::class, 'update'])->name('Patient.Profile.EmergencyContact.Update');

            Route::get('medical_history', [MedicalHistoryController::class, 'index'])->name('Patient.Profile.MedicalHistory.Index');
            Route::post('medical_history/update', [MedicalHistoryController::class, 'update'])->name('Patient.Profile.MedicalHistory.Update');

            Route::get('family_details', [FamilyDetailsController::class, 'index'])->name('Patient.Profile.FamilyDetails.Index');
            Route::post('family_details', [FamilyDetailsController::class, 'update'])->name('Patient.Profile.FamilyDetails.Update');

            Route::get('assessment_diagnosis', [AssessmentDiagnosisController::class, 'index'])->name('Patient.Profile.AssessmentDiagnosis.Index');
            Route::post('assessment_diagnosis', [AssessmentDiagnosisController::class, 'update'])->name('Patient.Profile.AssessmentDiagnosis.Update');
        });
        
        Route::prefix('covidvaxxins')->group(function(){
            Route::get('', [CovidVaccinationInsuranceController::class, 'index'])->name('Patient.COVIDVaccinationInsurance.Index');

            Route::post('covid_vaxstatus_insurance', [CovidVaccinationInsuranceController::class, 'update_vaxstatus_insurance'])->name('Patient.COVIDVaccinationInsurance.Update');

            Route::post('dossage_details_insert', [CovidVaccinationInsuranceController::class, 'insert_dossage_details'])->name('Patient.COVIDDossageDetails.Insert');
            Route::post('dossage_details_update/{id}', [CovidVaccinationInsuranceController::class, 'update_dossage_details'])->name('Patient.COVIDDossageDetails.Update');
            Route::post('dossage_details_delete/{id}', [CovidVaccinationInsuranceController::class, 'delete_dossage_details'])->name('Patient.COVIDDossageDetails.Delete');
       
            Route::post('file_uploads_insert', [CovidVaccinationInsuranceController::class, 'insert_file'])->name('Patient.COVIDFileUploads.Insert');
            Route::post('file_uploads_delete/{id}', [CovidVaccinationInsuranceController::class, 'delete_file'])->name('Patient.COVIDFileUploads.Delete');
        });

        Route::prefix('documents')->group(function(){
            Route::get('uploads', [DocumentUploadController::class, 'index'])->name('Patient.DocumentsUploads.Index');
            Route::post('insert', [DocumentUploadController::class, 'insert'])->name('Patient.DocumentsUploads.Insert');
            Route::post('uploads_delete/{id}', [DocumentUploadController::class, 'delete'])->name('Patient.DocumentsUploads.Delete');

            Route::get('prescription', [DocumentPrescriptionController::class, 'index'])->name('Patient.DocumentsPrescription.Index');
        });

        Route::prefix('attendance')->group(function(){
            Route::get('', [AttendanceController::class, 'index'])->name('Patient.Attendance.Index');
            Route::post('time_in', [AttendanceController::class, 'time_in'])->name('Patient.Attendance.TimeIn');
            Route::post('time_out/{id}', [AttendanceController::class, 'time_out'])->name('Patient.Attendance.TimeOut');
        });
    });

// =============================== End Patient ===============================================
