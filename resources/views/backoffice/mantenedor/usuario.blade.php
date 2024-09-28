@extends('backoffice.layouts.app')

@section('title', 'VentasFix | Dashboard')

@section('page-title', 'Dashboard')

@section('css')
.dataTables_length {
    display: none;
}
.dt-action-buttons > div {
    padding-right: 25px;
}
@endsection

@section('content')
<!-- Users List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">Filtro</h5>
    <div class="d-flex justify-content-between align-items-center row pt-4 gap-4 gap-md-0">
      <div class="col-md-4 user_role"></div>
      <div class="col-md-4 user_plan"></div>
      <div class="col-md-4 user_status"></div>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th></th>
          <th>Usuario</th>
          <th>Rut</th>
          <th>Status</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
      <form class="add-new-user pt-0" id="addNewUserForm" onsubmit="return false">
        <div class="mb-6">
          <label class="form-label" for="add-user-fullname">Nombre Completo</label>
          <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe" name="userFullname" aria-label="John Doe" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-user-email">Email</label>
          <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="userEmail" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-user-contact">Rut</label>
          <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="12345679-k" aria-label="john.doe@example.com" name="userContact" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-user-company">Contraseña</label>
          <input type="text" id="add-user-company" class="form-control" placeholder="pass" aria-label="jdoe1" name="companyName" />
        </div>
        <button type="submit" class="btn btn-primary me-3 data-submit">Registrar</button>
        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
      </form>
    </div>
  </div>
</div>
    <!-- Page JS -->
    <script src="../../assets/js/app-user-list.js"></script>
@endsection
