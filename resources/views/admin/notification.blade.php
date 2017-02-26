<?php
$notifications = $admin->toMeNotifications()->whereType('未读')->take(5)->orderBy('id', 'desc')->get(['id', 'from_id', 'title', 'created_at']);
?>

<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        @if(count($notifications))
            <span class="label label-danger" id="notification_count">{{ count($notifications) }}</span>
        @endif
    </a>
    <ul class="dropdown-menu">
        <li>
            <ul class="menu">
                @forelse($notifications as $notification)
                    <li>
                        <a href="#" class="notification" data-notification_id="{{ $notification->id }}">
                            <i class="fa fa-user text-{{ $notification->from_id ? 'blue' : 'red' }}"></i>
                            @if($notification->fromWhichAdmin)
                                {{ $notification->fromWhichAdmin->username }} :
                            @else
                                官方消息 :
                            @endif
                            {{ $notification->title }}
                            <span class="pull-right text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                    </li>
                @empty
                    <h4 class="text-muted text-center">没有消息</h4>
                @endforelse
            </ul>
        </li>
    </ul>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="myModalContent">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</li>

@section('scripts')
    @parent
    <script>
        $(function() {
            $(".notification").click(function() {
                var li = $(this).parent()
                var id = $(this).data('notification_id')
                var modal = $("#myModal")
                var title = $("#myModalLabel")
                var content = $("#myModalContent")
                var notification_count = $("#notification_count")
                $.getJSON("/admin/notification/info/" + id, function(json) {
                    title.html(json.title)
                    content.html(json.content)
                    modal.modal({
                        backdrop: false
                    })
                    li.remove()
                    notification_count.html(notification_count.html() - 1)
                })
                return false
            })
        })
    </script>
@endsection