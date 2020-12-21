@if(isset($_SESSION['msg_from_insert_status']))
    <?php
    $temp_session = flash_session('msg_from_insert_status');
    ?>
    <div class="alert alert-{{$temp_session['status']}}">
        {{$temp_session['msg']}}
    </div>
@endif