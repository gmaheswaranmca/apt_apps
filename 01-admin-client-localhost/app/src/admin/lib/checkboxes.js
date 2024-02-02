function allow_group_select_checkboxes(t) {
    for (var e = null, i = document.querySelectorAll("#" + t + ' input[type="checkbox"]'), n = 0; n < i.length; n++)
        i[n].setAttribute("data-index", n);
    for (n = 0; n < i.length; n++)
        i[n].addEventListener("click", function (t) {
            if (e && t.shiftKey) {
                var n = parseInt(e.getAttribute("data-index")),
                c = parseInt(this.getAttribute("data-index")),
                r = this.checked,
                a = n,
                l = c;
                if (n > c)
                    a = c, l = n;
                for (var d = 0; d < i.length; d++)
                    a <= d && d <= l && (i[d].checked = r)
            }
            e = this
        })
}
