@extends('Layouts.PatientMain')

@push('title')
    <title>Medical History</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Medical History</h1>
    </div>

    <section class="section profile">

        <div class="card">

            <div class="card-body pt-4">
                <form id="form_medical_history">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="row">
                        <span class="fw-bold sub-heading mb-2">Past Illness</span>
                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Hospitalization
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you&#39;ve hospitalized choose "Yes", else "No"'></i>
                                <select name="hospitalization" id="hospitalization" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhpi_hospitalization_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhpi_hospitalization_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="hospitalization_error"></div>
                            </div>
                            
                            <div class="col-lg-12">
                                Hospitalization Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of hospitalization?"></i>
                                <input type="text" name="hospitalization_specify" id="hospitalization_specify" class="form-control form-control-sm" 
                                    value="{{ ($user_details->mhpi_hospitalization_specify) ? $user_details->mhpi_hospitalization_specify : '' }}"
                                    {{ ($user_details->mhpi_hospitalization_specify) ? '' : 'disabled' }} 
                                >
                                <div class="invalid-feedback" id="hospitalization_specify_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Operation
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you had an operation choose "Yes", else "No"'></i>
                                <select name="operation" id="operation" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_operation_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhpi_operation_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="operation_error"></div>
                            </div>

                            <div class="col-lg-12">
                                Operation Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of operation?"></i>
                                <input type="text" name="operation_specify" id="operation_specify" class="form-control form-control-sm"
                                    value="{{ ($user_details->mhpi_operation_specify) ? $user_details->mhpi_operation_specify : '' }}"
                                    {{ ($user_details->mhpi_operation_specify) ? '' : 'disabled' }}  
                                >
                                <div class="invalid-feedback" id="operation_specify_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Accident
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you&#39;ve been accident before choose "Yes", else "No"'></i>
                                <select name="accident" id="accident" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhpi_accident_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhpi_accident_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="accident_error"></div>
                            </div>

                            <div class="col-lg-12">
                                Accident Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of accident?"></i>
                                <input type="text" name="accident_specify" id="accident_specify" class="form-control form-control-sm"
                                    value="{{ ($user_details->mhpi_accident_specify) ? $user_details->mhpi_accident_specify : '' }}"
                                    {{ ($user_details->mhpi_accident_specify) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="accident_specify_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Disability
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have disability choose "Yes", else "No"'></i>
                                <select name="disability" id="disability" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhpi_disability_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhpi_disability_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="disability_error"></div>
                            </div>

                            <div class="col-lg-12">
                                Disability Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of disability?"></i>
                                <select name="disability_specify" id="disability_specify" class="form-select form-select-sm"  {{ ($user_details->mhpi_disability_specify) ? '' : 'disabled' }}>
                                    <option value="">--- choose ---</option>
                                    @foreach($disability as $dis)
                                        <option value="{{ $dis->dis_id }}" {{ ($user_details->mhpi_disability_specify==$dis->dis_id) ? 'selected' : '' }}>{{ $dis->disability }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="disability_specify_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Asthma
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have asthma choose "Yes", else "No"'></i>
                                <select name="asthma" id="asthma" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhpi_asthma_last_attack) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhpi_asthma_last_attack) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="asthma_error"></div>
                            </div>

                            <div class="col-lg-12">
                                Asthma last attack
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Last occurence of your asthma"></i>
                                <input type="date" name="asthma_last_attack" id="asthma_last_attack" class="form-control form-control-sm"
                                    value="{{ (old('asthma',$user_details->mhpi_asthma_last_attack)) ? old('asthma_last_attack',$user_details->mhpi_asthma_last_attack) : '' }}"
                                    {{ (old('asthma',$user_details->mhpi_asthma_last_attack)) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="asthma_last_attack_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-9"></div>
                        
                        <div class="col-lg-3 mb-4">
                            Diabetes
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have diabetes choose "Yes", else "No"'></i>
                            <select name="diabetes" id="diabetes" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_diabetes=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_diabetes=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="diabetes_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Epilepsy
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have epilepsy choose "Yes", else "No"'></i>
                            <select name="epilepsy" id="epilepsy" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_epilepsy=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_epilepsy=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="epilepsy_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Heart Disease
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have heart disease choose "Yes", else "No"'></i>
                            <select name="heart_disease" id="heart_disease" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_heart_disease=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_heart_disease=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="heart_disease_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Hypertension
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have hypertension choose "Yes", else "No"'></i>
                            <select name="hypertension" id="hypertension" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_hypertension=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_hypertension=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="hypertension_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Measles
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have measles choose "Yes", else "No"'></i>
                            <select name="measles" id="measles" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_measles=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_measles=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="measles_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Mumps
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have mumps choose "Yes", else "No"'></i>
                            <select name="mumps" id="mumps" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_mumps=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_mumps=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="mumps_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Thyroid Problem
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have thyroid problem choose "Yes", else "No"'></i>
                            <select name="thyroid_problem" id="thyroid_problem" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_thyroid_problem=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_thyroid_problem=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="thyroid_problem_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Varicella
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have varicella choose "Yes", else "No"'></i>
                            <select name="varicella" id="varicella" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhpi_varicella=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhpi_varicella=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="varicella_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <span class="fw-bold sub-heading mb-2">Allergy</span>
                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Food
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you&#39;ve food allergy choose "Yes", else "No"'></i>
                                <select name="allergy_food" id="allergy_food" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mha_food_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mha_food_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="allergy_food_error"></div>
                            </div>
                            
                            <div class="col-lg-12">
                                Food Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of food?"></i>
                                <input type="text" name="allergy_food_specify" id="allergy_food_specify" class="form-control form-control-sm"
                                    value="{{ $user_details->mha_food_specify }}"
                                    {{ ($user_details->mha_food_specify) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="allergy_food_specify_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Medicine
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have medicine allergy choose "Yes", else "No"'></i>
                                <select name="allergy_medicine" id="allergy_medicine" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mha_medicine_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mha_medicine_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="allergy_medicine_error"></div>
                            </div>
                            
                            <div class="col-lg-12">
                                Medicine Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of food?"></i>
                                <input type="text" name="allergy_medicine_specify" id="allergy_medicine_specify" class="form-control form-control-sm"
                                    value="{{ $user_details->mha_medicine_specify }}"
                                    {{ ($user_details->mha_medicine_specify) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="allergy_medicine_specify_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <div class="col-lg-12 mb-2">
                                Others
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have other allergy choose "Yes", else "No"'></i>
                                <select name="allergy_others" id="allergy_others" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mha_others_specify) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mha_others_specify) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="allergy_others_error"></div>
                            </div>
                            
                            <div class="col-lg-12">
                                Other Specify
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="What kind of other allergy?"></i>
                                <input type="text" name="allergy_others_specify" id="allergy_others_specify" class="form-control form-control-sm"
                                    value="{{ $user_details->mha_others_specify }}"
                                    {{ ($user_details->mha_others_specify) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="allergy_others_specify_error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <span class="fw-bold sub-heading mb-2">Medical Immunization</span>

                        <div class="col-lg-3 mb-3">
                            <div class="col-lg-12 mb-2">
                                Hepa B
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top"  title='If you have received Hepa B vaccine choose "Yes", otherwise "No."'></i>
                                <select name="immunization_hepa_b" id="immunization_hepa_b" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhmi_hepa_b_doses) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhmi_hepa_b_doses) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="immunization_hepa_b_error"></div>
                            </div>
                           
                            <div class="col-lg-12">
                                Hepa B Doses
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Specify the number of hepa b doses"></i>
                                <input type="number" name="immunization_hepa_b_doses" id="immunization_hepa_b_doses" class="form-control" 
                                    value="{{ $user_details->mhmi_hepa_b_doses }}"
                                    {{ ($user_details->mhmi_hepa_b_doses) ? '' : 'disabled' }}            
                                >
                                <div class="invalid-feedback" id="immunization_hepa_b_doses_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            <div class="col-lg-12 mb-2">
                                DPT
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received DPT vaccine choose "Yes", otherwise "No."'></i>
                                <select name="immunization_dpt" id="immunization_dpt" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhmi_dpt_doses) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhmi_dpt_doses) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="immunization_dpt_error"></div>
                            </div>
                           
                            <div class="col-lg-12">
                                DPT Doses
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Specify the number of DPT doses"></i>
                                <input type="number" name="immunization_dpt_doses" id="immunization_dpt_doses" class="form-control"
                                    value="{{ $user_details->mhmi_dpt_doses }}"
                                    {{ ($user_details->mhmi_dpt_doses) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="immunization_dpt_doses_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            <div class="col-lg-12 mb-2">
                                OPV
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Oral Polivirus vaccine choose "Yes", otherwise "No."'></i>
                                <select name="immunization_opv" id="immunization_opv" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhmi_opv_doses) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhmi_opv_doses) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="immunization_opv_error"></div>
                            </div>
                           
                            <div class="col-lg-12">
                                OPV Doses
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Specify the number of OPV doses"></i>
                                <input type="number" name="immunization_opv_doses" id="immunization_opv_doses" class="form-control"
                                    value="{{ $user_details->mhmi_opv_doses }}"
                                    {{ ($user_details->mhmi_opv_doses) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="immunization_opv_doses_error"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            <div class="col-lg-12 mb-2">
                                HIB
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Haemophilus Influenzae B vaccine choose "Yes", otherwise "No."'></i>
                                <select name="immunization_hib" id="immunization_hib" class="form-select form-select-sm">
                                    <option value="0" {{ ($user_details->mhmi_hib_doses) ? '' : 'selected' }}>No</option>
                                    <option value="1" {{ ($user_details->mhmi_hib_doses) ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback" id="immunization_hib_error"></div>
                            </div>
                           
                            <div class="col-lg-12">
                                HIB Doses
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Specify the number of HIB doses"></i>
                                <input type="number" name="immunization_hib_doses" id="immunization_hib_doses" class="form-control"
                                    value="{{ $user_details->mhmi_hib_doses }}" 
                                    {{ ($user_details->mhmi_hib_doses) ? '' : 'disabled' }}
                                >
                                <div class="invalid-feedback" id="immunization_hib_doses"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            BCG
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Bacillus Calmette–Guérin vaccine choose "Yes", otherwise "No."'></i>
                            <select name="immunization_bcg" id="immunization_bcg" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhmi_bcg=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhmi_bcg=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="immunization_bcg_error"></div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            MMR
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Measles, Mumps, Rubella vaccine choose "Yes", otherwise "No."'></i>
                            <select name="immunization_mmr" id="immunization_mmr" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhmi_mmr=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhmi_mmr=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="immunization_mmr_error"></div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            Hepa A
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Hepa A vaccine choose "Yes", otherwise "No."'></i>
                            <select name="immunization_hepa_a" id="immunization_hepa_a" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhmi_hepa_a=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhmi_hepa_a=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="immunization_hepa_a_error"></div>
                        </div>

                        <div class="col-lg-3 mb-3">
                            Typhoid
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Typhoid vaccine choose "Yes", otherwise "No."'></i>
                            <select name="immunization_typhoid" id="immunization_typhoid" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhmi_typhoid=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhmi_typhoid=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="immunization_typhoid_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Varicella
                            <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you have received Varicella or Chickenpox vaccine choose "Yes", otherwise "No."'></i>
                            <select name="immunization_varicella" id="immunization_varicella" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->mhmi_varicella=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->mhmi_varicella=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="immunization_varicella_error"></div>
                        </div>
                    </div>


                    <div class="row">
                        <span class="fw-bold sub-heading mb-2">Pubertal History</span>

                        @if($user_details->sex=='male')
                            <div class="col-lg-3 mb-4">
                                Age on set
                                <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='Age you&#39;ve experienced puberty'></i>
                                <input type="number" name="pubertal_male_age_on_set" id="pubertal_male_age_on_set" class="form-control form-control-sm" value="{{ $user_details->mhp_male_age_on_set }}">
                                <div class="invalid-feedback" id="pubertal_male_age_on_set_error"></div>
                            </div>
                        @else
                            <div class="col-lg-3 mb-4">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        Menarche
                                        <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='Your first menstrual period'></i>
                                        <input type="number" name="pubertal_menarche" id="pubertal_menarche" class="form-control form-control-sm" value="{{ $user_details->mhp_female_menarche }}">
                                        <div class="invalid-feedback" id="pubertal_menarche_error"></div>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-4">
                                        LMP
                                        <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='Your last menstrual period'></i>
                                        <input type="date" name="pubertal_lmp" id="pubertal_lmp" class="form-control form-control-sm" value="{{ $user_details->mhp_female_lmp }}">
                                        <div class="invalid-feedback" id="pubertal_lmp_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        Dysmenorhea
                                        <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='If you&#39;ve experience dysmenorhea choose "Yes", else "No"'></i>
                                        <select name="pubertal_dysmenorhea" id="pubertal_dysmenorhea" class="form-select form-select-sm">
                                            <option value="0" {{ ($user_details->mhp_female_dysmenorhea=='0') ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ ($user_details->mhp_female_dysmenorhea=='1') ? 'selected' : '' }}>Yes</option>
                                        </select>
                                        <div class="invalid-feedback" id="pubertal_dysmenorhea_error"></div>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-4">
                                        Dysmenorhea Medicine
                                        <i class="bi bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title='What medicine are you taking for dysmenorrhea'></i>
                                        <input type="text" name="pubertal_dysmenorhea_medicine" id="pubertal_dysmenorhea_medicine" class="form-control form-control-sm"
                                            value="{{ $user_details->mhp_female_dysmenorhea_medicine }}"
                                            {{ ($user_details->mhp_female_dysmenorhea_medicine) ? '' : 'disabled' }}
                                        >
                                        <div class="invalid-feedback" id="pubertal_dysmenorhea_medicine_error"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-2">
                        <button class="btn btn-my-danger btn-sm w-100" type="button" id="form_medical_history_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_medical_history"></div>
                            <div class="text-light" id="lbl_medical_history">Save Changes</div>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </section>

  </main>
  <!-- main -->

@endsection

@push('script')
    <script>
        $('#hospitalization').change(function(){ clear_disable_enable_input(this, '#hospitalization_specify') });
        $('#operation').change(function(){ clear_disable_enable_input(this, '#operation_specify') });
        $('#accident').change(function(){ clear_disable_enable_input(this, '#accident_specify') });
        $('#disability').change(function(){ clear_disable_enable_input(this, '#disability_specify') });
        $('#asthma').change(function(){ clear_disable_enable_input(this, '#asthma_last_attack') });
        $('#allergy_food').change(function(){ clear_disable_enable_input(this, '#allergy_food_specify') });
        $('#allergy_medicine').change(function(){ clear_disable_enable_input(this, '#allergy_medicine_specify') });
        $('#allergy_others').change(function(){ clear_disable_enable_input(this, '#allergy_others_specify') });
        $('#immunization_hepa_b').change(function(){ clear_disable_enable_input(this, '#immunization_hepa_b_doses') });
        $('#immunization_dpt').change(function(){ clear_disable_enable_input(this, '#immunization_dpt_doses') });
        $('#immunization_opv').change(function(){ clear_disable_enable_input(this, '#immunization_opv_doses') });
        $('#immunization_hib').change(function(){ clear_disable_enable_input(this, '#immunization_hib_doses') });
        $('#pubertal_dysmenorhea').change(function(){ clear_disable_enable_input(this, '#pubertal_dysmenorhea_medicine') });

        $('#form_medical_history_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_medical_history','#lbl_loading_medical_history','#form_medical_history_submit',true);

            var formData = new FormData($('#form_medical_history')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Profile.MedicalHistory.Update') }}",
                contentType: false,
                processData: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);
                    if(response.status == 400){
                        $.each(response.errors, function(key, err_values){
                            $('#'+key+'_error').html(err_values);
                            $('#'+key).addClass('is-invalid');
                        });
                        swal(response.title, response.message, response.icon);
                    }
                    else{
                        swal(response.title,response.message,response.icon).then(function(){
                            history.go(0);
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                    swal('Failed!', 'Something went wrong! Please try again later', 'error');
                }
            }).always(function(){
                load_btn('#lbl_medical_history','#lbl_loading_medical_history','#form_medical_history_submit',false);
            });
        });
    </script>
@endpush