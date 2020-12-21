@if(isset($_SESSION['msg_from_insert_status']))
    <?php
    $temp_session = flash_session('msg_from_insert_status');
    ?>
    @if(isset($temp_session['modal']) && $temp_session['modal'])
        <div class="modal" tabindex="-1" id="Modal_show_msg">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="alert alert-{{$temp_session['status']}}">
                            {{$temp_session['msg']}}
                        </div>
                        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">باشه</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif
    @if(isset($temp_session['harmane']))
        @if($temp_session['harmane']==true)
            @include('include.harmane')
        @endif
    @endif
@endif