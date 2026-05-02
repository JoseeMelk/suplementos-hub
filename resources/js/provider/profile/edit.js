// =============================================
// EDICIÓN DE PERFIL (FUTURO - COMENTADO)
// =============================================
/*
const btnEdit        = document.getElementById('btnEditProfile');
const btnSave        = document.getElementById('btnSaveProfile');
const btnCancel      = document.getElementById('btnCancelEdit');
const editActions    = document.getElementById('editActions');
const photoInput     = document.getElementById('profilePhotoInput');
const avatarPreview  = document.getElementById('avatarPreview');

function enterEditMode() {
    // Mostrar inputs, ocultar textos
    document.getElementById('displayName').classList.add('d-none');
    document.getElementById('inputName').classList.remove('d-none');
    if (document.getElementById('displayBio')) {
        document.getElementById('displayBio').classList.add('d-none');
        document.getElementById('inputBio').classList.remove('d-none');
    }
    editActions.classList.remove('d-none');
    btnEdit.classList.add('d-none');
}

function exitEditMode() {
    document.getElementById('displayName').classList.remove('d-none');
    document.getElementById('inputName').classList.add('d-none');
    if (document.getElementById('displayBio')) {
        document.getElementById('displayBio').classList.remove('d-none');
        document.getElementById('inputBio').classList.add('d-none');
    }
    editActions.classList.add('d-none');
    btnEdit.classList.remove('d-none');
}

if (btnEdit)   btnEdit.addEventListener('click', enterEditMode);
if (btnCancel) btnCancel.addEventListener('click', exitEditMode);

// Preview foto antes de subir
if (photoInput) {
    photoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
            avatarPreview.innerHTML = `
                <img src="${ev.target.result}"
                    alt="Preview"
                    style="width:100%;height:100%;object-fit:cover;">
            `;
        };
        reader.readAsDataURL(file);
    });
}

// Guardar cambios (fetch al backend)
if (btnSave) {
    btnSave.addEventListener('click', async () => {
        btnSave.disabled = true;
        btnSave.innerHTML = '<i class="bi-hourglass-split me-1"></i>Guardando...';

        const formData = new FormData();
        formData.append('name', document.getElementById('inputName').value);
        if (document.getElementById('inputBio')) {
            formData.append('bio', document.getElementById('inputBio').value);
        }
        if (photoInput.files[0]) {
            formData.append('profile_photo', photoInput.files[0]);
        }
        formData.append('_method', 'PUT');

        try {
            const response = await fetch('{{ route("profile.update") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            });
            const data = await response.json();
            if (data.ok) {
                location.reload();
            } else {
                alert(data.message || 'Error al guardar');
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="bi-check2 me-1"></i>Guardar cambios';
            }
        } catch (err) {
            console.error(err);
            alert('Error al guardar los cambios');
            btnSave.disabled = false;
            btnSave.innerHTML = '<i class="bi-check2 me-1"></i>Guardar cambios';
        }
    });
}
*/