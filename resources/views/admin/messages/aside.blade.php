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
      <li class="nav-item active">
        <a href="{{ route('admin.messages.index') }}" class="nav-link {{ Request::is('admin/messages') ? 'active' : '' }}">
          <i class="fas fa-inbox"></i> Inbox
          <span class="badge bg-primary float-right">@if($unread_message->count()){{ $unread_message->count() }}@endif</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.messages.sent_messages') }}" class="nav-link {{ Request::is('admin/messages/sent*') ? 'active' : '' }}">
          <i class="far fa-envelope"></i> Sent
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.messages.trash_messages') }}" class="nav-link {{ Request::is('admin/messages/trash*') ? 'active' : '' }}">
          <i class="far fa-trash-alt"></i> Trash
        </a>
      </li>
    </ul>
  </div>
  <!-- /.card-body -->
</div>