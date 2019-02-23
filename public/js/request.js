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

  user: () => {
    if (TOKEN != '') {
      redRequest.token().get(URL + '/auth')
        .then(function (response) {
          userInfo = response.data;
          updateUserInfoOnPage();
        })
        .catch(function (error) {
          layer.msg(error.response.data['error_msg'], {
            time: 2000
          });
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
  //       console.log(22);
  //       app_images.images = response.data;
  //     })
  //     .catch(function (error) {
  //       layer.msg(error.response.data['error_msg'], {
  //         time: 2000
  //       });
  //     });
  //   // }
  // },

  token: () => {
    return axios.create({
      headers: {
        'Authorization': 'Bearer ' + TOKEN
      }
    });
  }
}

function updateUserInfoOnPage() {
  // header中的名字
  $('#header_user_name').text(userInfo['name']);
}