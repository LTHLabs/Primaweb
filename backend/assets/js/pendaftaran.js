document.addEventListener('DOMContentLoaded', function(){
  const form = document.getElementById('pendaftaranForm');
  if (!form) return;

  const MAX_FILE_COUNT = 3;
  const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

  function clearValidation(el){
    el.classList.remove('is-valid');
    el.classList.remove('is-invalid');
  }
  function setValid(el){
    // only mark valid when there is a value (or file selected) to avoid showing green on empty optional fields
    if (el.type === 'file'){
      if (!el.files || el.files.length === 0){
        return clearValidation(el);
      }
    } else {
      if (!(el.value || '').trim()){
        // if element is required, show invalid; otherwise clear
        if (el.required) return setInvalid(el, 'Field ini wajib diisi.');
        return clearValidation(el);
      }
    }
    el.classList.remove('is-invalid');
    el.classList.add('is-valid');
  }
  function setInvalid(el, message){
    el.classList.remove('is-valid');
    el.classList.add('is-invalid');
    const fb = el.nextElementSibling;
    if (fb && fb.classList && fb.classList.contains('invalid-feedback')) fb.textContent = message;
  }

  function isEmail(v){
    return /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v);
  }
  function isPhone(v){
    return /^[+\d][\d\s\-]{6,}$/.test(v);
  }

  function validateField(el){
    const id = el.id || el.name;
    const val = (el.value || '').trim();

    // text inputs
    if (id === 'nama'){
      if (!val || val.length < 3) return setInvalid(el, 'Masukkan nama lengkap (minimal 3 karakter).');
      return setValid(el);
    }
    if (id === 'nisn'){
      if (!val) return clearValidation(el);
      if (!/^\d{8,12}$/.test(val)) return setInvalid(el, 'NISN harus berupa angka (8–12 digit).');
      return setValid(el);
    }
    if (id === 'tempat_lahir'){
      if (!val) return clearValidation(el);
      if (val.length < 2) return setInvalid(el, 'Masukkan tempat lahir yang valid.');
      return setValid(el);
    }
    if (id === 'tanggal_lahir'){
      if (!val) return clearValidation(el);
      const d = new Date(val);
      const now = new Date();
      if (d > now) return setInvalid(el, 'Tanggal lahir tidak boleh di masa depan.');
      return setValid(el);
    }
    if (id === 'jenis_kelamin'){
      if (!val) return setInvalid(el, 'Pilih jenis kelamin.');
      return setValid(el);
    }
    if (id === 'alamat'){
      if (!val) return setInvalid(el, 'Masukkan alamat (minimal 10 karakter).');
      if (val.length < 10) return setInvalid(el, 'Masukkan alamat (minimal 10 karakter).');
      return setValid(el);
    }
    if (id === 'sekolah_asal'){
      if (!val) return setInvalid(el, 'Isi asal sekolah.');
      return setValid(el);
    }
    if (id === 'email'){
      if (!val) return clearValidation(el);
      if (!isEmail(val)) return setInvalid(el, 'Masukkan email yang valid.');
      return setValid(el);
    }
    if (id === 'telepon'){
      if (!val) return clearValidation(el);
      if (!isPhone(val)) return setInvalid(el, 'Masukkan nomor telepon yang valid (min 7 digit).');
      return setValid(el);
    }
    if (id === 'program_keahlian'){
      if (!val) return setInvalid(el, 'Pilih program keahlian.');
      return setValid(el);
    }
    if (id === 'proses_seleksi'){
      if (!val) return setInvalid(el, 'Pilih proses seleksi.');
      return setValid(el);
    }

    // file inputs validation
    if (el.type === 'file'){
      const files = el.files || [];
      if (el.multiple){
        if (files.length === 0) {
          if (el.required) return setInvalid(el, 'Unggah minimal 1 file untuk dokumen ini.');
          return clearValidation(el);
        }
        if (files.length > MAX_FILE_COUNT) return setInvalid(el, 'Unggah maksimal 3 file untuk tiap jenis dokumen.');
        // check sizes and types
        for (let i = 0; i < files.length; i++){
          const f = files[i];
          if (f.size > MAX_FILE_SIZE) return setInvalid(el, 'Terdapat file yang terlalu besar (maks 5MB).');
          if (!(f.type.startsWith('image/') || f.type === 'application/pdf')) return setInvalid(el, 'Terdapat file dengan format tidak didukung.');
        }
        return setValid(el);
      } else {
        if (!files.length) {
          if (el.required) return setInvalid(el, 'Unggah file untuk dokumen ini.');
          return clearValidation(el);
        }
        const f = files[0];
        if (f.size > MAX_FILE_SIZE) return setInvalid(el, 'Ukuran file terlalu besar (maks 5MB).');
        const okType = f.type.startsWith('image/') || f.type === 'application/pdf';
        if (!okType) return setInvalid(el, 'Format file tidak didukung.');
        return setValid(el);
      }
    }

    return true;
  }

  function validateAll(){
    const fields = form.querySelectorAll('input, textarea, select');
    let valid = true;
    fields.forEach(field => {
      const res = validateField(field);
      if (field.classList.contains('is-invalid')) valid = false;
    });
    return valid;
  }

  // attach listeners
  form.querySelectorAll('input, textarea, select').forEach(el => {
    const ev = el.tagName.toLowerCase() === 'select' || el.type === 'file' ? 'change' : 'input';
    el.addEventListener(ev, () => validateField(el));
  });

  form.addEventListener('submit', function(e){
    if (!validateAll()){
      e.preventDefault();
      e.stopPropagation();
      const firstInvalid = form.querySelector('.is-invalid');
      if (firstInvalid){
        firstInvalid.focus();
        firstInvalid.scrollIntoView({behavior:'smooth', block:'center'});
      }
    }
  });
});