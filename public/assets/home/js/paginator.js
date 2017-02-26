/**
 * Created by zaygeegee on 16/7/6.
 */

function loadPaginator(opts) {
    var container = opts.container
    var load_btn = opts.load_btn
    var data_url = opts.data_url
    var fmt_func = opts.format
    var after_func = opts.after || function() {}

    var cur_page = 1

    var load_data_func = function(json) {
        $(json.data).each(function() {
            container.append(fmt_func(this))
        })
        after_func(json)
        if(json.last_page <= cur_page - 1) {
            load_btn.unbind().html(cur_page == 2 && json.data.length == 0 ? '内容为空' : '最后一条')
            return
        }
    }

    load_btn.click(function() {
        $.getJSON(data_url + '?page=' + cur_page++, load_data_func)
    }).click()
}
