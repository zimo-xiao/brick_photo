var redRequest = {
  login: () => {
    var usin = $("#login_usin").val();
    var password = $("#login_password").val();

    if (usin != '' && password != '') {
      axios.post(URL + '/auth/login', {
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
      layer.msg('请不要留空', {
        time: 2000
      });
    }
  },

  findPassword: () => {
    var usin = $("#find_password_usin").val();

    if (usin != '') {
      axios.post(URL + '/auth/find-password', {
          usin: usin
        })
        .then(function (response) {
          layer.msg('验证邮箱已发到该学号所绑定的邮箱中，请查收', {
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
      redRequest.token().put(URL + '/image/' + id, {
          tags: tags
        })
        .then(function (response) {
          layer.msg('添加成功，请刷新查看', {
            time: 2000
          });
        })
        .catch(function (error) {
          layer.msg(error.response.data['error_msg'], {
            time: 2000
          });
        });
    } else {
      layer.msg('权限不正确', {
        time: 2000
      });
    }
  },

  addDescription: () => {
    var description = $("#description_box_input").val();
    var id = $("#description_box_image_id").val();

    if (description != null && TOKEN != '') {
      redRequest.token().put(URL + '/image/' + id, {
          description: description
        })
        .then(function (response) {
          layer.msg('添加成功，请刷新查看', {
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
  },

  logout: () => {
    redRequest.token().delete(URL + '/auth/logout', {})
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
      layer.msg('重复输入密码要和原密码一致哦', {
        time: 2000
      });
    } else if (password != '' && usin != '' && code != '') {
      axios.post(URL + '/auth/register', {
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
      layer.msg('请不要留空', {
        time: 2000
      });
    }
  },

  resetPassword: () => {
    var password = $("#reset_password_password").val();
    var reenterPassword = $("#reset_password_reenter_password").val();

    if (password != reenterPassword) {
      layer.msg('重复输入密码要和原密码一致哦', {
        time: 2000
      });
    } else if (password != '') {
      axios.post(URL + '/auth/reset-password/' + CODE, {
          password: password
        })
        .then(function (response) {
          alert('密码重置成功！请输入新密码重新登录');
          window.location = URL;
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
  },

  upload: () => {
    setTimeout(function () {
      if (files.length > 0) {
        for (var i in files) {
          var total = files[i].file.length;
          for (var j = 0; j < total; j++) {
            var form = new FormData();
            form.append("file", files[i].file[j]);
            form.append("name", files[i].name);
            form.append("total", total);
            form.append("index", j);
            form.append("end", files[i].end);
            $.ajax({
              url: URL + "/image",
              type: "POST",
              beforeSend: function (request) {
                request.setRequestHeader("Authorization", 'Bearer ' + TOKEN);
              },
              data: form,
              async: false, //异步
              processData: false, //很重要，告诉jquery不要对form进行处理
              contentType: false, //很重要，指定为false才能形成正确的Content-Type
              success: function (res) {
                if (res == 'instruction:again') {
                  j--;
                }
              },
              error: function (res) {
                alert(res.responseText);
                location.reload();
              }
            });
          }
        }
        layer.closeAll('loading');
        layer.open({
          title: '上传完成',
          content: '成功上传' + files.length + '张图片，请进入图库查看'
        });
        files = [];
      } else {
        layer.msg('请选择图片', {
          time: 2000
        });
      }
      $("#submit").show();
      $('#nosubmit').hide();
      $('#submit').text('已选择0张图片');
    }, 10);
  },

  // TODO: 异步渲染有问题，暂时不用这种方法
  // visitorImages: () => {
  //   // if (TOKEN == '') {
  //   redRequest.token().get(URL + '/image/visitor')
  //     .then(function (response) {
  //       app_images.images = response.data;
  //     })
  //     .catch(function (error) {
  //       layer.msg(error.response.data['error_msg'], {
  //         time: 2000
  //       });
  //     });
  //   // }
  // },

  download: () => {
    if (TOKEN != '') {
      var id = $("#download_box_image_id").val();
      var usage = $("#download_usage").val();

      if (usage != '' && id != '') {
        redRequest.token().post(URL + '/download/' + id, {
            usage: usage
          })
          .then(function (response) {
            var code = response.data['code'];
            var url = URL + '/download/action/' + code;
            redRequest.pop = layer.open({
              title: '知情同意',
              btn: [],
              content: '在下载图片时，本人同意将遵守「红砖平台使用协议」：用图署名作者，不在除声明用图场景外用图<br><br><a href="' + url + '" target="_blank" onclick="layer.close(redRequest.pop)" class="btn waves-effect waves-light" style="background-color: #EA5662">同意并下载图片</a>'
            });
          })
          .catch(function (error) {
            layer.msg(error.response.data['error_msg'], {
              time: 2000
            });
          });
      } else {
        layer.msg('请填写下载用途', {
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