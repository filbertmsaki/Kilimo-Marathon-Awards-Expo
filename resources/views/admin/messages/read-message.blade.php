@extends("admin.layout.app")
@section("title",'Read Message')
@section("pagename",'Read Message')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection
@section('script')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <a href="{{ route('admin.messages.index') }}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>
  
            @include('admin.messages.aside')
          <!-- /.card -->
        </div>
        <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Read Message</h3>

            <div class="card-tools">
              <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
              <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-read-info">
           
              <h5>{{ $threads->subject }}</h5>
           
              @foreach ($threads->messages as $message )
              <h6>From: @if($message->user->first_name !== null){{ $message->user->first_name.' '.$message->user->last_name}} @else {{  $message->user->email}}@endif  <span class="mailbox-read-time float-right">{{  $message->created_at->format('d-m-Y g:i A')}}</span></h6>
              @endforeach

          

              {{-- @if($threads->recipients)
              <span class="d-inline-block mr-5">To:
                @foreach($thread->recipients as $recipient)
                  <strong>{{ $recipient->name }}</strong>
                  {{ $thread->recipients->last()->id != $recipient->id ? ', ' : '' }}
                @endforeach
              </span>
            @endif --}}
          
            
          
                
            </div>
            
            <!-- /.mailbox-controls -->
            <div class="mailbox-read-message">
              @foreach($threads->messages as $message)
          
              <?php echo $message->body; ?>
         
            @endforeach
            </div>
            <!-- /.mailbox-read-message -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer ">
          
          </div>
          <!-- /.card-footer -->
          <div class="card-footer">
            <div class="float-right">
              <button type="button" class="btn btn-default" onclick="window.location='{{ route('admin.messages.index') }}'"><i class="fas fa-reply"></i> Back</button>
              {{-- <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button> --}}
            </div>
            <div class="float-left">
            <form action="{{ route('admin.messages.destroy', $threads) }}" method="post" id="delete-message-form">
                    @csrf
                    @method('delete')
            </form>
               <button type="submit" class="btn btn-default" form="delete-message-form"><i class="far fa-trash-alt"></i> Delete</button>
           
            <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
          </div></div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
@endsection