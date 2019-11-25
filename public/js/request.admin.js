var adminRequest = {
  deleteImage: () => {
    var id = $("#delete_box_image_id").val();
    var reason = $("#delete_box_reason").val();

    if (id != '' && reason != '') {
      redRequest.token().delete(THIS_URL + '/image/' + id, {
          data: {
            reason: reason
          }
        })
        .then(function (response) {
          layer.msg(intl.request.admin.deleteSuccess, {
            time: 2000
          });
        })
        .catch(function (error) {
          layer.msg(error.response.data['error_msg'], {
            time: 2000
          });
        });
    } else {
      layer.msg(intl.request.noEmpty, {
        time: 2000
      });
    }
  },

  deleteImageBatch: () => {
    layer.open({
      content: intl.request.admin.wantToDelete,
      btn: [intl.request.admin.deleteBtn],
      yes: function (index, layero) {
        var from = $("#delete_image_batch_from").val();
        var to = $("#delete_image_batch_to").val();
        redRequest.token().delete(THIS_URL + '/image/batch/range/' + from + '/' + to, {})
          .then(function (response) {
            layer.msg(intl.request.admin.deleteSuccess, {
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
          layer.msg(intl.request.admin.changePermissionSuccess, {
            time: 2000
          });
        })
        .catch(function (error) {
          layer.msg(error.response.data['error_msg'], {
            time: 2000
          });
        });
    } else {
      layer.msg(intl.request.noEmpty, {
        time: 2000
      });
    }
  }
}