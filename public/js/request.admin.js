var adminRequest = {
  deleteImage: () => {
    var id = $("#delete_box_image_id").val();
    var reason = $("#delete_box_reason").val();
    redRequest.token().delete(THIS_URL + '/image/' + id, {
        reason: reason
      })
      .then(function (response) {
        layer.msg('删除成功，请刷新查看', {
          time: 2000
        });
      })
      .catch(function (error) {
        layer.msg(error.response.data['error_msg'], {
          time: 2000
        });
      });
  },

  deleteImageBatch: () => {
    layer.open({
      content: '请问你是否要删除这些图片？',
      btn: ['删除'],
      yes: function (index, layero) {
        var from = $("#delete_image_batch_from").val();
        var to = $("#delete_image_batch_to").val();
        redRequest.token().delete(THIS_URL + '/image/batch/range/' + from + '/' + to, {})
          .then(function (response) {
            layer.msg('删除成功，请刷新查看', {
              time: 2000
            });
          })
          .catch(function (error) {
            layer.msg(error.response.data['error_msg'], {
              time: 2000
            });
          });
      },
      cancel: function () {}
    });
  },

  changePermission: () => {
    var usin = $("#change_permission_usin").val();
    var permission = $("#change_permission_permission").val();

    if (usin != '' && permission != '' && TOKEN != null) {
      redRequest.token().put(THIS_URL + '/auth/usin/' + usin, {
          permission: permission
        })
        .then(function (response) {
          layer.msg('更改成功，请让用户退出登录再登录', {
            time: 2000
          });
        })
        .catch(function (error) {
          layer.msg(error.response.data['error_msg'], {
            time: 2000
          });
        });
    } else {
      layer.msg('请不要留空', {
        time: 2000
      });
    }
  }
}