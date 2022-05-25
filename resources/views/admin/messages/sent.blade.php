@extends("admin.layout.app")
@section("title",'Sent Messages')
@section("pagename",'Sent Messages')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
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
<script>
  $(document).ready(function(){
          // tooltip
          $('[data-toggle="tooltip"]').tooltip()
  });
  </script>
<script>
    $(function () {
      //Enable check and uncheck all functionality
      $('.checkbox-toggle').click(function () {
        var clicks = $(this).data('clicks')
        if (clicks) {
          //Uncheck all checkboxes
          $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
          $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
        } else {
          //Check all checkboxes
          $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
          $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
        }
        $(this).data('clicks', !clicks)
      })
  
      //Handle starring for font awesome
      $('.mailbox-star').click(function (e) {
        e.preventDefault()
        //detect type
        var $this = $(this).find('a > i')
        var fa    = $this.hasClass('fa')
  
        //Switch states
        if (fa) {
          $this.toggleClass('fa-star')
          $this.toggleClass('fa-star-o')
        }
      })
    })
  </script>

@endsection

@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-3">
        <a href="{{ route('admin.messages.create') }}" class="btn btn-primary btn-block mb-3">New Message</a>

          @include('admin.messages.aside')
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Sent Messages</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Search Message">
                <div class="input-group-append">
                  <div class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <form action="{{ route('admin.messages.destroy_all_sent_message') }}"  method="POST">
            @csrf
            @method('delete')
              <div class="card-body p-0">
                <div class="mailbox-controls">
                  <!-- Check all button -->
                  <button type="button" class="btn btn-default btn-sm checkbox-toggle" data-toggle="tooltip" data-placement="top" title="Check All"><i class="far fa-square"></i>
                  </button>
                  <div class="btn-group">
                    <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="far fa-trash-alt"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                  <div class="float-right">
                    {!! $threads->links() !!}
                  
                    <!-- /.btn-group -->
                  </div>
                  <!-- /.float-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped">
                    <tbody>
                      @forelse($threads as $thread)
                        <tr>
                          <td>
                            <div class="icheck-primary">
                              <input type="checkbox" value="{{ $thread->id }}" name="thread_id[]" id="check{{ $thread->id }}">
                              <label for="check{{ $thread->id }}"></label>
                            </div>
                          </td>
                          <td class="mailbox-name"><a href="{{ route('admin.messages.read_sent_messages', $thread) }}">{{ $thread->participantsString(Auth::id()) }} 	</a></td>
                          <td class="mailbox-subject">{{ Str::limit($thread->subject, 50) }}
                          </td>
                          <td class="mailbox-attachment"></td>
                          <td class="mailbox-date">{{ $thread->updated_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                          <div class="list-group-item p-5">
                            <h3 class="text-center font-weight-bold">There are no sent messages</h3>
                          </div>

                    @endforelse
                    </tbody>
                  </table>
                  <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer p-0">
                <div class="mailbox-controls">
                  <!-- Check all button -->
                  <button type="button" class="btn btn-default btn-sm checkbox-toggle" data-toggle="tooltip" data-placement="top" title="Check All"><i class="far fa-square"></i>
                  </button>
                  <div class="btn-group">
                    <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="far fa-trash-alt"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                  <div class="float-right">
                    {!! $threads->links() !!}
                  
                    <!-- /.btn-group -->
                  </div>
                  <!-- /.float-right -->
                </div>
              </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  
@endsection