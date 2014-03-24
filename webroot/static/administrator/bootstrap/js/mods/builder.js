$(document).ready(function() {
  if (g_ctrl == "validators") {
    $("select[name='validator_name']").change(function() {
      Builder.loadMessageByValidatorName();
    });
    Builder.loadMessageByValidatorName();
  }
});

/**
 * Builder
 * @author songhuan <trotri@yeah.net>
 * @version $Id: builder.js 1 2013-10-16 18:38:00Z $
 */
Builder = {
  /**
   * 新增或编辑字段验证管理，选择“验证类名”时改变“出错提示消息”
   * @return void
   */
  loadMessageByValidatorName: function() {
    var validatorName = $("select[name='validator_name']").val();
    var fieldName = $(":text[name='field_name']").val();

    var optionCategory = optionCategoryEnum[messageEnum[validatorName]['option_category']];
    var message = messageEnum[validatorName]['message'].replace("{field}", fieldName);

    $(":text[name='options']").parent().next("span").html("Suggest: " + optionCategory);
    $(":text[name='message']").val(message);
  }
}
