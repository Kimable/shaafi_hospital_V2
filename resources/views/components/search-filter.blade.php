<div class="search_filter">
    <div class="container py-3">
        <h4 class="text-center text-white" style="font-size: 1.1rem; font-weight: 800; margin: 1rem 0">
            {{__("Search for a Specific Doctor or Specialty")}}
        </h4>
        <form action="{{ route('search.search') }}" method="post">
            @csrf
            <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                <div class="m-1">
                    <select name="specialty" class="form-select" id="specialty">
                        <option value="">
                            --{{ __("Choose Specialty") }}--
                        </option>
                        <option value="Orthopaedic and Spinal Surgery">
                            {{__("Orthopaedic and Spinal Surgery")}}
                        </option>
                        <option value="Otorhinolaryngology, Head and Neck Surgery">
                            {{__("Otorhinolaryngology, Head and Neck Surgery (ENT)")}}
                        </option>
                        <option value="Paediatric">
                            {{__("Paediatric and Paediatric Surgery")}}
                        </option>
                        <option value="Plastic Surgery">{{__("Plastic Surgery")}}</option>
                        <option value="Anaesthesiology">{{__("Anaesthesiology")}}</option>
                        <option value="Cardiology">{{__("Cardiology")}}</option>
                        <option value="Electrophysiology">
                            {{__("Electrophysiology")}}
                        </option>
                        <option value="Internal Medicine">
                            Internal Medicine
                        </option>
                        <option value="Cardiothoracic">
                            Cardiothoracic Surgery
                        </option>
                        <option value="Clinical Psychology">
                            Clinical Psychology
                        </option>
                        <option value="Dentistry">Dentistry</option>
                        <option value="Dermatology">Dermatology</option>
                        <option value="Diabetology">Diabetology</option>
                        <option value="Endocrinology">Endocrinology</option>
                        <option value="Emergency Medicine">
                            Emergency Medicine
                        </option>
                        <option value="Gastroenterology">
                            Gastroenterology
                        </option>
                        <option value="Colorectal Surgery">
                            Colorectal Surgery
                        </option>
                        <option value="Thoracic Surgery">
                            Thoracic Surgery
                        </option>
                        <option value="Surgery">General Surgery</option>
                        <option value="Rheumatology">Rheumatology</option>
                        <option value="Nephrology">Nephrology</option>
                        <option value="Neuro-Behavioural Medicine">
                            Neuro-Behavioural Medicine
                        </option>
                        <option value="Neurology">Neurology</option>
                        <option value="Neurosurgery">Neurosurgery</option>
                        <option value="Nuclear Medicine">
                            Nuclear Medicine
                        </option>
                        <option value="Gynaecology">Gynaecology</option>
                        <option value="Obstetrics">Obstetrics</option>
                        <option value="Consultant">Medical Consultant</option>
                        <option value="Laparoscopy">Laparoscopy</option>
                        <option value="Occupational Health">
                            Occupational Health
                        </option>
                        <option value="Preventive Medicine">
                            Preventive Medicine
                        </option>
                        <option value="Oncology">Oncology</option>
                        <option value="Ophthalmology">Ophthalmology</option>
                        <option value="Oral-Maxillofacial Surgery">
                            Oral-Maxillofacial Surgery
                        </option>
                        <option value="Orthodontics">Orthodontics</option>
                        <option value="Orthopaedic">Orthopaedic</option>

                        <option value="Neonatology">Neonatology</option>
                        <option value="Radiology">Radiology</option>
                        <option value="Urology">Urology</option>
                        <option value="Wellness">Wellness</option>
                    </select>
                </div>

                <!-- <div class="m-1">
                    <select name="category" class="form-select" id="category">
                        <option value="">
                            --{{ __("Choose Category") }}--
                        </option>
                        <option value="Bones and Joints">
                            Bones and Joints
                        </option>
                        <option value="Brain">Brain</option>
                        <option value="Breast">Breast</option>
                        <option value="Cancer">Cancer</option>
                        <option value="Children and Newborns">
                            Children and Newborns
                        </option>
                        <option value="Clinical Psychology">
                            Clinical Psychology
                        </option>
                        <option value="Cosmetic Surgery">
                            Cosmetic Surgery
                        </option>
                        <option value="Dental">Dental</option>
                        <option value="Diabetes">Diabetes</option>
                        <option value="Ear">Ear</option>
                        <option value="Throat">Throat</option>
                        <option value="Nose">Nose</option>
                        <option value="Endocrinology">Endocrinology</option>
                        <option value="Endoscopy Gastrointestinal">
                            Endoscopy Gastrointestinal
                        </option>
                        <option value="Eye">Eye</option>
                        <option value="Gastroenterology">
                            Gastroenterology
                        </option>
                        <option value="General Surgery">General Surgery</option>
                        <option value="Heart">Heart</option>
                        <option value="Hypertension">Hypertension</option>
                        <option value="Internal Medicine">
                            Internal Medicine
                        </option>
                        <option value="Rheumatology">Rheumatology</option>
                        <option value="Interventional Radiology">
                            Interventional Radiology
                        </option>
                        <option value="Kidney">Kidney</option>
                        <option value="Lung">Lung</option>
                        <option value="Maternity">Maternity</option>
                        <option value="Mens's Health">Men&#039;s Health</option>
                        <option value="Nuclear Medicine">
                            Nuclear Medicine
                        </option>
                        <option value="Occupational Health">
                            Occupational Health
                        </option>
                        <option value="Preventive Medicine">
                            Preventive Medicine
                        </option>
                        <option value="Psychiatry">Psychiatry</option>
                        <option value="Skin">Skin</option>
                        <option value="Spine Injury">Spine Injury</option>
                        <option value="Stroke">Stroke</option>
                        <option value="Womens's Health">
                            Women&#039;s Health
                        </option>
                    </select>
                </div> -->

                <div class="m-1">
                    <select name="doctor" class="form-select" id="doctor">
                        <option selected>--{{ __("Choose Doctor") }}--</option>
                        @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->user->id }}">
                            Dr. {{ $doctor->user->first_name }}
                            {{ $doctor->user->last_name }} ({{$doctor->specialty






                            }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="m-1">
                    <button class="btn btn-primary search_filter_btn" type="submit">
                        {{ __("Search") }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>