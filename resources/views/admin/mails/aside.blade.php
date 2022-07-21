<div class="card">
    <div class="card-header">
      <h3 class="card-title">Folders</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-pills flex-column">
        {{-- <li class="nav-item active">
          <a href="#" class="nav-link ">
            <i class="fas fa-inbox"></i> Inbox
            <span class="badge bg-primary float-right">0</span>
          </a>
        </li> --}}
     
        <li class="nav-item active">
          <a href="{{ route('admin.mails.mailshot.create') }}" class="nav-link  {{ Request::is('admin/mails/mailshot*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Voting - Mailshot
          </a>
        </li>
      </ul>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
