function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}

function bukaModal(id, judul) {
    document.getElementById('editId').value = id; // pakai parameter id
    document.getElementById('editJudul').value = judul; // pakai parameter judul
    document.getElementById('modalEdit').style.display = 'flex'; // buka edit
}

function tutupModal() {
    document.getElementById('modalEdit').style.display = 'none'; // tutup edit
}