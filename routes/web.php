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

    use App\Http\Controllers\Patient\PasswordController as PasswordController;

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

        Route::prefix('password')->group(function(){
            Route::get('', [PasswordController::class, 'index'])->name('Patient.ChangePassword.Index');
            Route::post('update', [PasswordController::class, 'update'])->name('Patient.ChangePassword.Update');
        });
    });

// =============================== Start Admin ===============================================
    use App\Http\Controllers\Admin\Transaction\AttendanceCodeController as AdminAttendanceCodeController;
    use App\Http\Controllers\Admin\Transaction\TransactionController as AdminAttendanceController;
    use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;

    use App\Http\Controllers\Admin\Configuration\Medicine\BrandController as AdminMedicineBrandController;
    use App\Http\Controllers\Admin\Configuration\Medicine\GenericNameController as AdminMedicineGenericNameController;

    use App\Http\Controllers\Admin\Configuration\Equipment\PlaceController as AdminEquipmentPlaceController;
    use App\Http\Controllers\Admin\Configuration\Equipment\TypeController as AdminEquipmentTypeController;
    use App\Http\Controllers\Admin\Configuration\Equipment\BrandController as AdminEquipmentBrandController;
    use App\Http\Controllers\Admin\Configuration\Equipment\NameController as AdminEquipmentNameController;
    use App\Http\Controllers\Admin\Configuration\Equipment\ItemController as AdminEquipmentItemController;
    
    use App\Http\Controllers\Admin\Inventory\Equipment\AllController as AdminInventoryEquipmentAllController;
    use App\Http\Controllers\Admin\Inventory\Equipment\ItemController as AdminInventoryEquipmentItemController;
    use App\Http\Controllers\Admin\Inventory\Equipment\ReportController as AdminInventoryEquipmentReportController;
    
    use App\Http\Controllers\Admin\Inventory\Medicine\AllController as AdminInventoryMedicineAllController;
    use App\Http\Controllers\Admin\Inventory\Medicine\ItemController as AdminInventoryMedicineItemController;
    use App\Http\Controllers\Admin\Inventory\Medicine\ReportController as AdminInventoryMedicineReportController;
    
    Route::group(['prefix' => 'ip'], function(){

        Route::get('default_route', function(){
            return redirect()->route('Admin.Transaction.CensusCode.Index');
        })->name('infirmary_personnel');

        Route::prefix('transaction')->group(function(){
            Route::get('attendance/{date}',[AdminAttendanceController::class, 'index'])->name('Admin.Transaction.Attendance.Index');

            Route::get('census_code', [AdminAttendanceCodeController::class, 'index'])->name('Admin.Transaction.CensusCode.Index');
            Route::get('census_code/{id}', [AdminAttendanceCodeController::class, 'update_status'])->name('Admin.Transaction.CensusCode.Update');
            Route::get('census_code/new/{date}', [AdminAttendanceCodeController::class, 'get_new_code'])->name('Admin.Transaction.CensusCode.Create');
        });

        Route::prefix('announcement')->group(function(){
            Route::get('', [AdminAnnouncementController::class, 'index'])->name('Admin.Announcement.Index');
            Route::post('insert', [AdminAnnouncementController::class, 'insert'])->name('Admin.Announcement.Insert');
            Route::post('update/{id}', [AdminAnnouncementController::class, 'update'])->name('Admin.Announcement.Update');
            Route::post('delete/{id}', [AdminAnnouncementController::class, 'delete'])->name('Admin.Announcement.Delete');
        });

        Route::prefix('configuration')->group(function(){

            Route::prefix('medicine')->group(function(){
                Route::get('brand', [AdminMedicineBrandController::class, 'index'])->name('Admin.Medicine.Brand.Index');
                Route::post('brand/insert', [AdminMedicineBrandController::class, 'insert'])->name('Admin.Medicine.Brand.Insert');
                Route::post('brand/update/{id}', [AdminMedicineBrandController::class, 'update'])->name('Admin.Medicine.Brand.Update');
                Route::post('brand/delete/{id}', [AdminMedicineBrandController::class, 'delete'])->name('Admin.Medicine.Brand.Delete');

                Route::get('genericname', [AdminMedicineGenericNameController::class, 'index'])->name('Admin.Medicine.GenericName.Index');
                Route::post('genericname/insert', [AdminMedicineGenericNameController::class, 'insert'])->name('Admin.Medicine.GenericName.Insert');
                Route::post('genericname/update/{id}', [AdminMedicineGenericNameController::class, 'update'])->name('Admin.Medicine.GenericName.Update');
                Route::post('genericname/delete/{id}', [AdminMedicineGenericNameController::class, 'delete'])->name('Admin.Medicine.GenericName.Delete');
            });

            Route::prefix('equipment')->group(function(){
                Route::get('place', [AdminEquipmentPlaceController::class, 'index'])->name('Admin.Equipment.Place.Index');
                Route::post('place/insert', [AdminEquipmentPlaceController::class, 'insert'])->name('Admin.Equipment.Place.Insert');
                Route::post('place/update/{id}', [AdminEquipmentPlaceController::class, 'update'])->name('Admin.Equipment.Place.Update');
                Route::post('place/delete/{id}', [AdminEquipmentPlaceController::class, 'delete'])->name('Admin.Equipment.Place.Delete');

                Route::get('type', [AdminEquipmentTypeController::class, 'index'])->name('Admin.Equipment.Type.Index');
                Route::post('type/insert', [AdminEquipmentTypeController::class, 'insert'])->name('Admin.Equipment.Type.Insert');
                Route::post('type/update/{id}', [AdminEquipmentTypeController::class, 'update'])->name('Admin.Equipment.Type.Update');
                Route::post('type/delete/{id}', [AdminEquipmentTypeController::class, 'delete'])->name('Admin.Equipment.Type.Delete');

                Route::get('brand', [AdminEquipmentBrandController::class, 'index'])->name('Admin.Equipment.Brand.Index');
                Route::post('brand/insert', [AdminEquipmentBrandController::class, 'insert'])->name('Admin.Equipment.Brand.Insert');
                Route::post('brand/update/{id}', [AdminEquipmentBrandController::class, 'update'])->name('Admin.Equipment.Brand.Update');
                Route::post('brand/delete/{id}', [AdminEquipmentBrandController::class, 'delete'])->name('Admin.Equipment.Brand.Delete');

                Route::get('name', [AdminEquipmentNameController::class, 'index'])->name('Admin.Equipment.Name.Index');
                Route::post('name/insert', [AdminEquipmentNameController::class, 'insert'])->name('Admin.Equipment.Name.Insert');
                Route::post('name/update/{id}', [AdminEquipmentNameController::class, 'update'])->name('Admin.Equipment.Name.Update');
                Route::post('name/delete/{id}', [AdminEquipmentNameController::class, 'delete'])->name('Admin.Equipment.Name.Delete');

                Route::get('item', [AdminEquipmentItemController::class, 'index'])->name('Admin.Equipment.Item.Index');
                Route::post('item/insert', [AdminEquipmentItemController::class, 'insert'])->name('Admin.Equipment.Item.Insert');
                Route::post('item/update/{id}', [AdminEquipmentItemController::class, 'update'])->name('Admin.Equipment.Item.Update');
                Route::post('item/delete/{id}', [AdminEquipmentItemController::class, 'delete'])->name('Admin.Equipment.Item.Delete');
            });
        });

        Route::prefix('inventory')->group(function(){
            Route::get('equipment', [AdminInventoryEquipmentAllController::class, 'index'])->name('Admin.Inventory.Equipment.All.Index');
            
            Route::get('equipment/item', [AdminInventoryEquipmentItemController::class, 'index'])->name('Admin.Inventory.Equipment.Item.Index');
            Route::post('equipment/item/insert', [AdminInventoryEquipmentItemController::class, 'insert'])->name('Admin.Inventory.Equipment.Item.Insert');
            Route::post('equipment/item/update/{id}', [AdminInventoryEquipmentItemController::class, 'update'])->name('Admin.Inventory.Equipment.Item.Update');
            Route::post('equipment/item/delete/{id}', [AdminInventoryEquipmentItemController::class, 'delete'])->name('Admin.Inventory.Equipment.Item.Delete');

            Route::get('equipment/report/{year}', [AdminInventoryEquipmentReportController::class, 'index'])->name('Admin.Inventory.Equipment.Report.Index');
            Route::get('equipment/print/{year}', [AdminInventoryEquipmentReportController::class, 'print'])->name('Admin.Inventory.Equipment.Report.Print');
        
            
            Route::get('medicine', [AdminInventoryMedicineAllController::class, 'index'])->name('Admin.Inventory.Medicine.All.Index');

            Route::get('medicine/item', [AdminInventoryMedicineItemController::class, 'index'])->name('Admin.Inventory.Medicine.Item.Index');
            Route::post('medicine/item/insert', [AdminInventoryMedicineItemController::class, 'insert'])->name('Admin.Inventory.Medicine.Item.Insert');
            Route::post('medicine/item/update/{id}', [AdminInventoryMedicineItemController::class, 'update'])->name('Admin.Inventory.Medicine.Item.Update');
            Route::post('medicine/item/delete/{id}', [AdminInventoryMedicineItemController::class, 'delete'])->name('Admin.Inventory.Medicine.Item.Delete');

            Route::post('medicine/item/dispose/{id}', [AdminInventoryMedicineItemController::class, 'dispose'])->name('Admin.Inventory.Medicine.Item.Dispose.Insert');

            Route::get('meidicine/item/transaction/{id}', [AdminInventoryMedicineItemController::class, 'transaction_index'])->name('Admin.Inventory.Medicine.Item.Transaction.Index');
            Route::post('meidicine/item/transaction/delete/{id}', [AdminInventoryMedicineItemController::class, 'transaction_delete'])->name('Admin.Inventory.Medicine.Item.Transaction.Delete');

            Route::get('medicine/report', [AdminInventoryMedicineReportController::class, 'index'])->name('Admin.Inventory.Medicine.Report.Index');
            Route::get('medicine/report/print', [AdminInventoryMedicineReportController::class, 'print'])->name('Admin.Inventory.Medicine.Report.Print');
        });
    });