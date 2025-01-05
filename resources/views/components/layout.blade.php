<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- Favicons -->

        <link
            rel="icon"
            type="image/png"
            href="{{ url('favicon/apple-icon.png') }}"
        />
        <!-- Favicons end -->
        <!-- Bootstrap CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
            crossorigin="anonymous"
        />

        <!-- Google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Montaga&family=Work+Sans&display=swap"
            rel="stylesheet"
        />
        <!-- Bootstrap-icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        />

        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ url('css/style.css') }}" />
        <title>{{ $title . ' | Shaafi Hospital' ?? 'Shaafi Hospital' }}</title>
    </head>

    <body>
        <!-- Navbar -->
        <div class="nav-header">
            <div
                class="container d-flex justify-content-between align-items-center py-3"
            >
                <div class="logo">
                    <a class="navbar-brand" href="/">
                        <img
                            src="{{ url('img/shaafi-logo-text-white.png') }}"
                            alt="Logo"
                        />
                    </a>
                </div>
                <div class="emergency-contact">
                    <p>
                        <span style="color: var(--secondary); font-weight: 700"
                            ><i
                                style="margin-right: 0.6rem"
                                class="bi bi-telephone-forward"
                            ></i
                            >{{ __("Call Us 24/7") }}</span
                        ><a href="tel:+252612877778"> +252 61 2877778</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- For Mobile Devices -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <div class="logo">
                    <a class="navbar-brand" href="/">
                        <img
                            src="{{
                                url('img/shaafi-logo-text-transparent.png')
                            }}"
                            alt="Shaafi Hospital Logo"
                        />
                    </a>
                </div>
                <button
                    class="navbar-toggler shadow-none border-0"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="sidebar offcanvas offcanvas-end"
                    tabindex="-1"
                    id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel"
                >
                    <div class="offcanvas-header">
                        <div id="offcanvasNavbarLabel" class="navbar-logo">
                            <img
                                width="150px"
                                src="img/shaafi-logo-text-transparent.png"
                                alt="Nav Logo"
                            />
                        </div>
                        <button
                            type="button"
                            class="btn-close btn-close-white shadow-none border-0"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="offcanvas-body">
                        @if (auth()->check() && auth()->user()->role ==
                        'doctor')
                        <ul
                            class="navbar-nav justify-content-center align-items-center flex-grow-1 pe-3"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/doctor-profile"
                                    >Profile</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/dashboard"
                                    >Dashboard</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/doctors/manage-appointments"
                                    >Appointments</a
                                >
                            </li>
                        </ul>
                        <div class="d-flex flex-column">
                            <a class="appointment-btn" href="/logout">Logout</a>
                        </div>
                        @elseif(auth()->check() && auth()->user()->role ==
                        'admin')
                        <ul
                            class="navbar-nav justify-content-center align-items-center flex-grow-1 pe-3"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/dashboard"
                                    >Dashboard</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/admin/manage-doctors"
                                    >Manage Doctors</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/admin/add-doctor"
                                    >Add Doctor</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    aria-current="page"
                                    href="/admin/messages"
                                    >Messages</a
                                >
                            </li>
                        </ul>
                        <div class="d-flex flex-column">
                            <a class="appointment-btn" href="/logout">Logout</a>
                        </div>
                        @else
                        <ul
                            class="navbar-nav justify-content-center align-items-center"
                        >
                            <!-- Find a Doctor -->
                            <li class="nav-item">
                                <a class="nav-link" href="/doctors">{{
                                    __("Find a Doctor")
                                }}</a>
                            </li>

                            <!-- Medical Treatments Dropdown -->
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ __("Medical Treatments") }}
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <!-- Specialties -->
                                    <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Our Specialties") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Cardiothoracic Surgery"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Oncology & Cancer")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Diabetic Services")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Liver Transplant")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Anaesthesiology")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Dermatology") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "IVF & Infertility Treatments"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Nutrition & Health")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Physiotherapy")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("General Surgery")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Internal Medicine")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Paediatrics") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Ophthalmology")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Psychiatry") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Radiology & Imaging"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Procudures -->
                                    <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Procedures") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Chemotherapy") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Bone Marrow transplant"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Abdominal Sergery")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Biopsy") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Gastric Bypass")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Heart Transplant")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Hysterectomy") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Immunotherapy")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Liver Resection Surgery"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "General & Reconstructive Surgery"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Pancreatic Resection & Surgery"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Spine Fusion surgery"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Pulmonary Function Testing"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Prostate Resection")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Photocoagulation")
                                                    }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Center of Excellence -->
                                    <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Center of Excellence") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Heart Center") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Oncology Center")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Research Center")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Lifestyle Center")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Renal & Care Center"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Dental Care Center")
                                                    }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- General Services -->
                                    <li class="nav-item">
                                        <a
                                            class="dropdown-item"
                                            aria-current="page"
                                            href="/services"
                                            >{{ __("General Services") }}</a
                                        >
                                    </li>

                                    <!-- Multi dispiplinary team -->
                                    <!-- <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Multidisciplinary Team") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Lung Cancer") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Bone and Soft Tissues"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Breast Cancer")
                                                    }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li> -->

                                    <!-- Anciliary Servives -->
                                    <!-- <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Anciliary Services") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Physiotherapy")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Laboratory & Blood Bank"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Diabetic Services")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Clinical Research Services"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Pharmacy") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __(
                                                            "Speech-language Therapy"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li> -->

                                    <!-- Medical Checkup -->
                                    <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Medical Check Up") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Vaccination") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Wellness Check Up")
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Screening") }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{ __("Lifestyle") }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- End Medical Treatments Dropdown -->

                            <!-- Community Services Dropdown -->

                            <!-- <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ __("Community Services") }}
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/development"
                                            >{{ __("Community") }}</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/development"
                                            >{{ __("Charity") }}</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/development"
                                            >{{ __("Support Group") }}</a
                                        >
                                    </li>
                                    <li class="nav-item dropend">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            id="navbarDropdown"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ __("Training & Classes") }}
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="navbarDropdown"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/life-support-training"
                                                    >{{
                                                        __(
                                                            "Life Support Training"
                                                        )
                                                    }}</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="/development"
                                                    >{{
                                                        __("Pre-natal Classes")
                                                    }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> -->

                            <!-- End Community Services Dropdown -->

                            <!-- <li class="nav-item">
                                <a class="nav-link" href="/patient-guide">{{
                                    __("Patient Guide")
                                }}</a>
                            </li> -->

                            <li class="nav-item">
                                <a href="/appointment" class="nav-link">{{
                                    __("Appointment")
                                }}</a>
                            </li>

                            <!-- My Reports -->
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="/login">{{
                                    __("My Reports")
                                }}</a>
                            </li> -->

                            <!-- About Dropdown -->
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ __("About") }}
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/about"
                                            >{{ __("About Us") }}</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/our-story"
                                            >{{ __("Our Story") }}</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/development"
                                            >{{
                                                __("Awards and Accredation")
                                            }}</a
                                        >
                                    </li>
                                </ul>
                            </li>

                            <!-- Get In Touch -->
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ __("Get In Touch") }}
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/contact"
                                            >{{ __("Contact Us") }}</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/development"
                                            >{{ __("Careers") }}</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="/development"
                                            >{{
                                                __("Volunteer Opportunity")
                                            }}</a
                                        >
                                    </li>
                                </ul>
                            </li>
                            <!-- End Get In Touch -->

                            <li class="nav-item" style="cursor: pointer">
                                <a class="nav-link" id="quickIquiry">{{
                                    "Quick Inquiry"
                                }}</a>
                            </li>

                            <!-- Languages -->
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ __("Language") }}
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    @foreach (config('app.locales') as $locale
                                    => $language)
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('setLocale', $locale) }}"
                                        >{{ $language }}</a
                                    >
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <x-quick-inquiry-pop-up />

        <!-- Content -->
        {{ $slot }}
        <!-- Content End -->

        <!-- Footer -->
        <div class="footer">
            <footer class="container py-5">
                <div class="row">
                    <div class="col-6 col-md-3 mb-3">
                        <img
                            src="{{ url('img/shaafi-logo-text.png') }}"
                            alt="Logo"
                        />
                        <p class="mt-3">
                            {{
                                __(
                                    "Leading the Way in Medical Excellence and Trusted Care."
                                )
                            }}
                        </p>
                    </div>

                    <div class="col-6 col-md-2 mb-3">
                        <h5>{{ __("Explore") }}</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <a href="/appointment" class="nav-link p-0">{{
                                    __("Appointment")
                                }}</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="/services" class="nav-link p-0">{{
                                    __("Services")
                                }}</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="/doctors" class="nav-link p-0">{{
                                    __("Doctors")
                                }}</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="/about" class="nav-link p-0">{{
                                    __("About Us")
                                }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="contact col-6 col-md-2 mb-3">
                        <h5>{{ __("Contact Us") }}</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <span
                                    ><i class="bi bi-telephone-forward"></i>
                                    {{ __("Call Us") }}</span
                                ><a
                                    href="tel:+252612877778"
                                    class="nav-link p-0"
                                >
                                    +252 61 2877778</a
                                >
                            </li>
                            <li class="nav-item mb-2">
                                <span
                                    ><i class="bi bi-envelope"></i>
                                    {{ __("Email") }}</span
                                >
                                <a
                                    href="mailto:info@shaafihospital.so"
                                    class="nav-link p-0"
                                    >info@shaafihospital.so</a
                                >
                            </li>
                            <li class="nav-item mb-2">
                                <span
                                    ><i class="bi bi-geo-alt"></i>
                                    {{ __("Visit Us") }}</span
                                ><a href="#" class="nav-link p-0">
                                    {{
                                        __(
                                            "Dagmada Hodon Mogadishu Banaadir, Somalia"
                                        )
                                    }}</a
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div class="col-md-4 offset-md-1 mb-3">
                        <h5>{{ __("Download Our App") }}</h5>
                        <p>
                            {{
                                __(
                                    "To easily manage your appointments, download our app."
                                )
                            }}
                        </p>
                        <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                            <a
                                href="{{
                                    url(
                                        'https://play.google.com/store/apps/details?id=com.kkimani.shaafihospital&pcampaignid=web_share'
                                    )
                                }}"
                                target="_blank"
                            >
                                <img
                                    style="width: 150px"
                                    src="{{ url('img/playstore.png') }}"
                                    alt="W3Schools"
                                />
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="social d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top"
                >
                    <p>
                        &copy; <span class="year"></span>
                        {{ __("Shaafi Hospital. All rights reserved.") }}
                    </p>
                    <ul class="list-unstyled d-flex">
                        <li class="ms-3">
                            <a
                                class="link-body-emphasis"
                                href="https://wa.me/+252612877778"
                                ><i class="bi bi-whatsapp"></i
                            ></a>
                        </li>
                        <li class="ms-3">
                            <a
                                class="link-body-emphasis"
                                href="https://www.facebook.com/IsbitaalkaShaafi/"
                                ><i class="bi bi-facebook"></i
                            ></a>
                        </li>
                    </ul>
                </div>
            </footer>
        </div>
        <!-- Footer End-->
        <!-- .Sticky Navbar bottom -->
        <div class="bottom-nav">
            <style>
                .bottom-nav a:hover {
                    color: var(--primary-light);
                }
            </style>
            <div class="container">
                <div
                    class="fixed-bottom d-flex justify-content-center align-items-center"
                >
                    <div class="item">
                        <a href="/appointment">
                            <img
                                width="30px"
                                src="/img/icons/ecg_heart.png"
                                alt="Check Up"
                            />
                        </a>
                        <a class="link-text" href="/appointment">Checkup</a>
                    </div>
                    <div class="item">
                        <a href="/appointment">
                            <img
                                width="30px"
                                src="/img/icons/calendar.png"
                                alt="Appointment"
                            />
                        </a>
                        <a class="link-text" href="/appointment">Appointment</a>
                    </div>
                    <div class="item">
                        <a href="/doctors">
                            <img
                                width="30px"
                                src="/img/icons/stethoscope.png"
                                alt="Stethoscope"
                            />
                        </a>
                        <a class="link-text" href="/doctors"> Doctors</a>
                    </div>
                    <div class="item">
                        <a href="/contact">
                            <img
                                width="33px"
                                src="/img/icons/emergency.png"
                                alt="Emergency"
                            />
                        </a>
                        <a class="link-text" href="/contact">Emergency</a>
                    </div>
                </div>
            </div>
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"
        ></script>
        <script>
            const year = document.querySelector(".year");
            const dateObj = new Date().getFullYear();
            year.textContent = dateObj;
        </script>
    </body>
</html>
