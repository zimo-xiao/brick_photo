// npm install -g canvas
// npm link canvas
// npm install -g exif
// npm link exif
// npm install move-file -g
// npm link move-file
const {
  createCanvas,
  loadImage
} = require('canvas');
const ExifImage = require('exif').ExifImage;
const fs = require("fs");
const moveFile = require('move-file');
var args = process.argv.slice(2);
var toRawDir = args[0];
var toCacheDir = args[1];
var imgDir = args[2];
var name = args[3];
var end = args[4];

loadImage(imgDir).then((image) => {
  var quality = 0.1;
  // 确定尺寸
  var dev = 8;
  var w = image.width;
  var h = image.height;
  var scale = w / h;
  if (w >= 700) {
    dev = 1;
    w = 700;
    h = w / scale;
  }
  // 生成canvas
  new ExifImage({
    image: imgDir
  }, function (error, exifData) {
    var orientation = 1;
    if (!error) {
      orientation = exifData.image.Orientation;
    }

    if (orientation == 90) {
      orientation = 6;
    }
    if (orientation == 180) {
      orientation = 3;
    }
    if (orientation == 270) {
      orientation = 8;
    }
    orientation = orientation ? orientation : 1;
    // 创建属性节点
    if (orientation <= 4) {
      var canvas = createCanvas(w / dev, h / dev);
      var ctx = canvas.getContext('2d');
      // 设置压缩canvas区域高度及宽度
      if (orientation == 3 || orientation == 4) {
        ctx.translate(w / dev, h / dev);
        ctx.rotate(180 * Math.PI / 180);
      }
    } else {
      var canvas = createCanvas(h / dev, w / dev);
      var ctx = canvas.getContext('2d');
      // 设置压缩canvas区域高度及宽度
      if (orientation == 5 || orientation == 6) {
        ctx.translate(h / dev, 0);
        ctx.rotate(90 * Math.PI / 180);
      } else if (orientation == 7 || orientation == 8) {
        ctx.translate(0, w / dev);
        ctx.rotate(270 * Math.PI / 180);
      }
    }
    // 绘制
    ctx.drawImage(image, 0, 0, w / dev, h / dev);
    // 保存
    fs.writeFile(toCacheDir + name + '.jpg', canvas.toDataURL('image/jpeg', quality).replace(/^data:image\/jpeg;base64,/, ""), 'base64', function (err) {});
    (async () => {
      await moveFile(imgDir, toRawDir + name + '.' + end);
    })();
  });
});