<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-danger" id="bell_count">0</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <ul class="menu" id="un_read_lists">
                <h4 style="cursor: pointer" class="text-muted text-center" id="loadMoreBtn"><a onclick="loadMore()">加载更多</a></h4>
            </ul>
        </li>
    </ul>
</li>

@section('scripts')
    @parent
    <script>
        $(".menu").click(function() {
            return false;
        })
        $(function() {
            $('<audio id="chatAudio"><source src="/audio/notify.ogg" type="audio/ogg"><source src="/audio/notify.mp3" type="audio/mpeg"><source src="/audio/notify.wav" type="audio/wav"></audio>').appendTo('body');
            var bell_count = $("#bell_count")

            var count = 0;
            var id = ''
            var more_id = '';

            var ulCtn = $("#un_read_lists")
            function makeLi(obj) {
                return $("<li></li>").append($('<a href="/admin/order/info/'+obj.id+'" class="notification"></a>').append(obj.id + '新订单 :<span class="pull-right text-muted">'+obj.created_at+'</span>').click(function() {
                    window.open("/admin/order/info/" + obj.id)
                    --count
                    $(this).parent().remove()
                    bell_count.html(count)
                }))
            }
            function prepend(obj) {
                ulCtn.prepend(makeLi(obj))
            }

            function append(obj) {
                ulCtn.children('li').last().after(makeLi(obj))
            }

            (function getList() {
                $.getJSON('/admin/order/un-read-list/' + id, function(json) {
                    if(json.code == 0) {
                        id = json.data[0].id
                        if(more_id == '') {
                            more_id = json.data[json.data.length - 1].id
                        }
                        $(json.data.reverse()).map(function() {
                            ++count
                            prepend(this)
                        })
                        bell_count.html(json.total)
                        $('#chatAudio')[0].play();
                        toastr.success('发现' + json.total + '条未处理订单', '有新的订单', {
                            onclick: function() {
                                setTimeout(function() {
                                    $($(".dropdown-toggle")[1]).click()
                                }, 100)
                            }
                        })
                    }
                    getList()
                })
            })()
            window.loadMore = function() {
                $.getJSON('/admin/order/more-un-read-list/' + more_id, function(json) {
                    if(json.data.length > 0) {
                        more_id = json.data[json.data.length - 1].id
                        $(json.data).map(function() {
                            append(this)
                        })
                         bell_count.html(json.total)
                    } else {
                        $("#loadMoreBtn").hide()
                        // 没有更多了
                    }
                })
            }
        })
    </script>
@endsection