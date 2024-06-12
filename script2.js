//Handling registration for different users
const activePatientR = document.querySelector('.patient_r');
const activeDoctorR = document.querySelector('.doctor_r');
const activePharmacyR = document.querySelector('.pharmacy_r');
const activeCompanyR = document.querySelector('.company_r');
const wrapper = document.querySelector('.wrapper');
const patientACR = document.querySelector('.register_patient');
const doctorACR = document.querySelector('.register_doctor');
const pharmacyACR = document.querySelector('.register_pharmacy');
const companyACR = document.querySelector('.register_company');

activePatientR.addEventListener('click', ()=> {
    wrapper.style.height = "800px";
    patientACR.classList.add('active');
    pharmacyACR.classList.remove('active');
    doctorACR.classList.remove('active');
    companyACR.classList.remove('active');
})

activeDoctorR.addEventListener('click', ()=> {
    wrapper.style.height = "700px";
  doctorACR.classList.add('active');
  patientACR.classList.remove('active');
  pharmacyACR.classList.remove('active');
  companyACR.classList.remove('active');

})

activePharmacyR.addEventListener('click', ()=> {
    wrapper.style.height = "700px";
    pharmacyACR.classList.add('active');
    patientACR.classList.remove('active');
    doctorACR.classList.remove('active');
    companyACR.classList.remove('active');
})

activeCompanyR.addEventListener('click', ()=> {
    wrapper.style.height = "570px";
  companyACR.classList.add('active');
  patientACR.classList.remove('active');
  pharmacyACR.classList.remove('active');
  doctorACR.classList.remove('active');

})

