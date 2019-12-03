class Compress {
    constructor(file, w, objDiv, result) {
        this.storage = new Storage();
    }

    process(name, data, isAppend = false) {

    }

    algorithm() {
        var dev = 8;
        var w = this.width,
            h = this.height,
            scale = w / h;

        if (w >= 700) {
            dev = 1;
            w = 700;
            h = w / scale;
        }
        w = obj.width || w;
        h = obj.height || (w / scale);
        var quality = 0.1; // 默认图片质量为0.7
        //生成canvas
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var orientation = 1;
        //获取图像的方位信息
        EXIF.getData(img, function () {
            orientation = parseInt(EXIF.getTag(img, "Orientation"));
            orientation = orientation ? orientation : 1;
        });
        // 创建属性节点
        if (orientation <= 4) {
            canvas.setAttribute("height", h / dev);
            canvas.setAttribute("width", w / dev);
            // 设置压缩canvas区域高度及宽度
            if (orientation == 3 || orientation == 4) {
                ctx.translate(w / dev, h / dev);
                ctx.rotate(180 * Math.PI / 180);
            }
        } else {
            canvas.setAttribute("height", w / dev);
            canvas.setAttribute("width", h / dev);
            // 设置压缩canvas区域高度及宽度
            if (orientation == 5 || orientation == 6) {
                ctx.translate(h / dev, 0);
                ctx.rotate(90 * Math.PI / 180);
            } else if (orientation == 7 || orientation == 8) {
                ctx.translate(0, w / dev);
                ctx.rotate(270 * Math.PI / 180);
            }
        }
        drawImageIOSFix(ctx, img, 0, 0, that.width, that.height, 0, 0, w / dev, h / dev);
        ctx.drawImage(that, 0, 0, w / dev, h / dev);
        // 图像质量
        if (obj.quality && obj.quality <= 1 && obj.quality > 0) {
            quality = obj.quality;
        }
        // quality值越小，所绘制出的图像越模糊
        var base64 = canvas.toDataURL('image/jpeg', quality);
        // 回调函数返回base64的值
        callback(base64 + '#**#' + result);
    }
}

export default Compress

function compress(file, w, objDiv, result) {
    var ready = new FileReader();
    /*开始读取指定的Blob对象或File对象中的内容. 当读取操作完成时,readyState属性的值会成为DONE,如果设置了onloadend事件处理程序,则调用之.同时,result属性中将包含一个data: URL格式的字符串以表示所读取文件的内容.*/
    ready.readAsDataURL(file);
    ready.onload = function () {
        var re = this.result;
        canvasDataURL(re, w, objDiv, result);
    }
}

function canvasDataURL(path, obj, callback, result) {
    var img = new Image();
    //安卓获取的base64数据无信息头，加之
    if (path.substring(5, 10) != "image") {
        img.src = path.replace(/(.{5})/, "$1image/jpeg;");
    } else {
        img.src = path;
    }
    img.onload = function () {
        var dev = 8;
        var that = this;
        // 默认按比例压缩
        var w = that.width,
            h = that.height,
            scale = w / h;
        if (w >= 700) {
            dev = 1;
            w = 700;
            h = w / scale;
        }
        w = obj.width || w;
        h = obj.height || (w / scale);
        var quality = 0.1; // 默认图片质量为0.7
        //生成canvas
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var orientation = 1;
        //获取图像的方位信息
        EXIF.getData(img, function () {
            orientation = parseInt(EXIF.getTag(img, "Orientation"));
            orientation = orientation ? orientation : 1;
        });
        // 创建属性节点
        if (orientation <= 4) {
            canvas.setAttribute("height", h / dev);
            canvas.setAttribute("width", w / dev);
            // 设置压缩canvas区域高度及宽度
            if (orientation == 3 || orientation == 4) {
                ctx.translate(w / dev, h / dev);
                ctx.rotate(180 * Math.PI / 180);
            }
        } else {
            canvas.setAttribute("height", w / dev);
            canvas.setAttribute("width", h / dev);
            // 设置压缩canvas区域高度及宽度
            if (orientation == 5 || orientation == 6) {
                ctx.translate(h / dev, 0);
                ctx.rotate(90 * Math.PI / 180);
            } else if (orientation == 7 || orientation == 8) {
                ctx.translate(0, w / dev);
                ctx.rotate(270 * Math.PI / 180);
            }
        }
        drawImageIOSFix(ctx, img, 0, 0, that.width, that.height, 0, 0, w / dev, h / dev);
        ctx.drawImage(that, 0, 0, w / dev, h / dev);
        // 图像质量
        if (obj.quality && obj.quality <= 1 && obj.quality > 0) {
            quality = obj.quality;
        }
        // quality值越小，所绘制出的图像越模糊
        var base64 = canvas.toDataURL('image/jpeg', quality);
        // 回调函数返回base64的值
        callback(base64 + '#**#' + result);
    }
}

function detectVerticalSquash(img) {
    var iw = img.naturalWidth,
        ih = img.naturalHeight;
    var canvas = document.createElement('canvas');
    canvas.width = 1;
    canvas.height = ih;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);
    var data = ctx.getImageData(0, 0, 1, ih).data;
    // search image edge pixel position in case it is squashed vertically.
    var sy = 0;
    var ey = ih;
    var py = ih;
    while (py > sy) {
        var alpha = data[(py - 1) * 4 + 3];
        if (alpha === 0) {
            ey = py;
        } else {
            sy = py;
        }
        py = (ey + sy) >> 1;
    }
    var ratio = (py / ih);
    return (ratio === 0) ? 1 : ratio;
}

/**
 * A replacement for context.drawImage
 * (args are for source and destination).
 */
function drawImageIOSFix(ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
    var vertSquashRatio = detectVerticalSquash(img);
    // Works only if whole image is displayed:
    // ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
    // The following works correct also when only a part of the image is displayed:
    ctx.drawImage(img, sx * vertSquashRatio, sy * vertSquashRatio,
        sw * vertSquashRatio, sh * vertSquashRatio,
        dx, dy, dw, dh);
}