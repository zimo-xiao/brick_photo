var redRequest = {
  login: () => {
    var usin = $("#login_usin").val();
    var password = $("#login_password").val();

    if (usin != '' && password != '') {
      axios.post(THIS_URL + '/auth/login', {
          usin: usin,
          password: password
        })
        .then(function (response) {
          location.reload();
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

  findPassword: () => {
    var usin = $("#find_password_usin").val();

    if (usin != '') {
      axios.post(THIS_URL + '/auth/find-password', {
          usin: usin
        })
        .then(function (response) {
          layer.msg(intl.request.findPass, {
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

  addTags: () => {
    var tags = [];
    var id = $("#tags_box_image_id").val();
    $(".tags_box_select:checked").each(
      function () {
        tags.push($(this).val());
      }
    );

    if (TOKEN != '') {
      redRequest.token().put(THIS_URL + '/image/' + id, {
          tags: tags
        })
        .then(function (response) {
          layer.msg(intl.request.addTags, {
            time: 2000
          });
        })
        .catch(function (error) {
          layer.msg(error.response.data['error_msg'], {
            time: 2000
          });
        });
    } else {
      layer.msg(intl.request.permissionDenied, {
        time: 2000
      });
    }
  },

  addDescription: () => {
    var description = $("#description_box_input").val();
    var id = $("#description_box_image_id").val();

    if (description != null && TOKEN != '') {
      redRequest.token().put(THIS_URL + '/image/' + id, {
          description: description
        })
        .then(function (response) {
          layer.msg(intl.request.addDescription, {
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

  logout: () => {
    redRequest.token().delete(THIS_URL + '/auth/logout', {})
      .then(function (response) {
        location.reload();
      })
      .catch(function (error) {
        layer.msg(error.response.data['error_msg'], {
          time: 2000
        });
      });
  },

  register: () => {
    var usin = $("#register_usin").val();
    var code = $("#register_code").val();
    var password = $("#register_password").val();
    var reenterPassword = $("#register_reenter_password").val();

    if (password != reenterPassword) {
      layer.msg(intl.request.samePass, {
        time: 2000
      });
    } else if (password != '' && usin != '' && code != '') {
      axios.post(THIS_URL + '/auth/register', {
          usin: usin,
          code: code,
          password: password
        })
        .then(function (response) {
          location.reload();
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

  resetPassword: () => {
    var password = $("#reset_password_password").val();
    var reenterPassword = $("#reset_password_reenter_password").val();

    if (password != reenterPassword) {
      layer.msg(intl.request.samePass, {
        time: 2000
      });
    } else if (password != '') {
      axios.post(THIS_URL + '/auth/reset-password/' + CODE, {
          password: password
        })
        .then(function (response) {
          alert(intl.request.resetPass);
          window.location = THIS_URL;
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

  upload: (i, j) => {
    if (files.length == 0) {
      layer.msg(intl.request.selectImg, {
        time: 2000
      });
      return;
    }

    var total = files[i].file.length;
    redRequest.token().post(THIS_URL + '/image', {
        file: files[i].file[j],
        total: total,
        index: j,
        name: files[i].name,
        end: files[i].end
      })
      .then(function (response) {
        if ((j + 1) < total) {
          j = j + 1;
          redRequest.upload(i, j);
        } else {
          // 如果这张图片传完了，看是不是到最后一张图片了
          if ((i + 1) < files.length) {
            // 不是则继续传
            j = 0;
            i = i + 1;
            redRequest.upload(i, j);
          } else {
            layer.closeAll('loading');
            layer.open({
              title: intl.request.uploadedTitle,
              content: intl.request.uploadedContent.replace('[counter]', files.length)
            });
            $("#submit").show();
            $('#nosubmit').hide();
            $('#submit').text(intl.request.uploadBtn.replace('[counter]', 0));
            files = [];
          }
        }
      })
      .catch(function (error) {
        // 重新上传
        j--;
        redRequest.upload(i, j);
      });
  },

  download: () => {
    if (TOKEN != '') {
      var id = $("#download_box_image_id").val();
      var usage = $("#download_usage").val();

      if (usage != '' && id != '') {
        redRequest.token().post(THIS_URL + '/download/' + id, {
            usage: usage
          })
          .then(function (response) {
            var code = response.data['code'];
            var url = THIS_URL + '/download/action/' + code;
            redRequest.pop = layer.open({
              title: intl.request.downloadAlertTitle,
              btn: [],
              content: intl.request.downloadAlertContent + '<br><br><a href="' + url + '" target="_blank" onclick="layer.close(redRequest.pop)" class="btn waves-effect waves-light" style="background-color: var(--color)">' + intl.request.downloadAlertBtn + '</a>'
            });
          })
          .catch(function (error) {
            layer.msg(error.response.data['error_msg'], {
              time: 2000
            });
          });
      } else {
        layer.msg(intl.request.downloadRequireUsage, {
          time: 2000
        });
      }
    }
  },

  token: () => {
    return axios.create({
      headers: {
        'Authorization': 'Bearer ' + TOKEN
      }
    });
  },

  pop: null
}