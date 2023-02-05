<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">

        <li class="nav-item">
            <a class="nav-link collapsed" href="" id="side_bar_announcement">
                <i class="bi bi-megaphone"></i>
                <span>Announcement</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="" id="sidebar_dashboard">
                <i class="bi bi-clock"></i>
                <span>Attendance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" id="sidebar_user_documents"  data-bs-target="#document-nav" data-bs-toggle="collapse" >
                <i class="bi bi-filetype-doc"></i>
                <span>Documents</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="document-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="">
                        <i class="bi bi-circle"></i><span>Uploads</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="bi bi-circle"></i><span>Prescription</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Profile -->
        <li class="nav-item">
            <a class="nav-link {{ (str_contains(url()->current(),'pt/profile')) ? '' : 'collapsed' }}" href="#" id="sidebar_user_information"  data-bs-target="#profile-nav" data-bs-toggle="collapse" >
                <i class="bi bi-person"></i>
                <span>Profile</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="profile-nav" class="nav-content collapse {{ (str_contains(url()->current(),'pt/profile')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('Patient.Profile.PersonalDetails.Index') }}" class="{{ (str_contains(url()->current(),route('Patient.Profile.PersonalDetails.Index'))) ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Personal Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Patient.Profile.EmergencyContact.Index') }}" class="{{ (str_contains(url()->current(),route('Patient.Profile.EmergencyContact.Index'))) ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Emergency Contact</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Patient.Profile.MedicalHistory.Index') }}" class="{{ (str_contains(url()->current(),route('Patient.Profile.MedicalHistory.Index'))) ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Medical History</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Patient.Profile.FamilyDetails.Index') }}" class="{{ (str_contains(url()->current(),route('Patient.Profile.FamilyDetails.Index'))) ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Family Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('Patient.Profile.AssessmentDiagnosis.Index') }}" class="{{ (str_contains(url()->current(),route('Patient.Profile.AssessmentDiagnosis.Index'))) ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Assessment Diagnosis</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Covid Vaccination and Insurance -->
        <li class="nav-item">
            <a class="pe-0 nav-link collapsed" href="" id="sidebar_vaccination_and_insurance">
                <i class="bi bi-clipboard-check"></i>
                <span >CoVid Vax. and Ins.</span>
            </a>
        </li>

    </li>

</ul>

</aside>