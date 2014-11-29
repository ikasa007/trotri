$(document).ready(function() {
  if (g_ctrl == "members" && g_act == "index") {
    Member.ajaxAccount();
  }
});

/**
 * Member
 * @author songhuan <trotri@yeah.net>
 * @version $Id: member.js 1 2013-10-16 18:38:00Z $
 */
Member = {
  /**
   * 批量禁用
   * @param string url
   * @return void
   */
  batchForbidden: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") {
      $("#dialog_alert_view_body").html("请选中禁用项！");
      $("#dialog_alert").modal("show");
      return ;
    }

    url += "&ids=" + ids + "&column_name=forbidden&value=y";
    Trotri.href(url);
  },

  /**
   * 批量解除禁用
   * @param string url
   * @return void
   */
  batchUnforbidden: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") {
      $("#dialog_alert_view_body").html("请选中解除禁用项！");
      $("#dialog_alert").modal("show");
      return ;
    }

    url += "&ids=" + ids + "&column_name=forbidden&value=n";
    Trotri.href(url);
  },

  /**
   * 提交会员账户
   * @return void
   */
  ajaxAccount: function() {
    var setError = function(errMsg) {
      $("#dialog_ajax_view_body .form-group").addClass("has-error");
      $("#dialog_ajax_view_body :text[name='value']").focus().select();
    };

    var btn = $("#dialog_ajax_view .btn");
    btn.removeAttr("data-dismiss");
    btn.click(function() {
      var url = $("#dialog_ajax_view_body :hidden[name='url']").val();
      var value = $("#dialog_ajax_view_body :text[name='value']").val();
      if (value != "") {
        Trotri.href(url + value);
      }
      else {
        setError();
      }
    });
  }
}