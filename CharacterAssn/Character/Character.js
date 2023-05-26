"use strict";

var canvas;
var gl;
var Head = {
    numElements: 36,
    vertices: [
        vec4(-0.5, -0.3, 0.25, 1.0),
        vec4(-0.5, 0.3, 0.25, 1.0),
        vec4(0.5, 0.3, 0.25, 1.0),
        vec4(0.5, -0.3, 0.25, 1.0),
        vec4(-0.5, -0.3, -0.25, 1.0),
        vec4(-0.5, 0.3, -0.25, 1.0),
        vec4(0.5, 0.3, -0.25, 1.0),
        vec4(0.5, -0.3, -0.25, 1.0)],

    vertexColors: [
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
    ],
    indices: [
        1, 0, 3,
        3, 2, 1,
        2, 3, 7,
        7, 6, 2,
        3, 0, 4,
        4, 7, 3,
        6, 5, 1,
        1, 2, 6,
        4, 5, 6,
        6, 7, 4,
        5, 4, 0,
        0, 1, 5
    ],
    materialAmbient: vec4(0.7, 0.5, 0.45, 1.0),
    materialDiffuse: vec4(0.9, 0.75, 0.6, 1.0),
    materialSpecular: vec4(0.9, 0.75, 0.6, 1.0),
    materialShininess: 20.0
}
var Body = {
    numElements: 36,
    vertices: [
        vec4(-0.5, -0.65, 0.25, 1.0),
        vec4(-0.5, 0.65, 0.25, 1.0),
        vec4(0.5, 0.65, 0.25, 1.0),
        vec4(0.5, -0.65, 0.25, 1.0),
        vec4(-0.5, -0.65, -0.25, 1.0),
        vec4(-0.5, 0.65, -0.25, 1.0),
        vec4(0.5, 0.65, -0.25, 1.0),
        vec4(0.5, -0.65, -0.25, 1.0)],

    vertexColors: [
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
        vec4(0.5, 0.8, 1.0, 1.0),
    ],
    indices: [
        1, 0, 3,
        3, 2, 1,
        2, 3, 7,
        7, 6, 2,
        3, 0, 4,
        4, 7, 3,
        6, 5, 1,
        1, 2, 6,
        4, 5, 6,
        6, 7, 4,
        5, 4, 0,
        0, 1, 5
    ],
    materialAmbient: vec4(0.25, 0.4, 0.5, 1.0),
    materialDiffuse: vec4(0.5, 0.8, 1.0, 1.0),
    materialSpecular: vec4(0.0, 0.4, 0.4, 1.0),
    materialShininess: 100.0
}
var LeftArm = {
    numElements: 36,
    vertices: [
        vec4(0, -0.15, 0.15, 1.0),
        vec4(0, 0.15, 0.15, 1.0),
        vec4(1.0, 0.15, 0.15, 1.0),
        vec4(1.0, -0.15, 0.15, 1.0),
        vec4(0, -0.15, -0.15, 1.0),
        vec4(0, 0.15, -0.15, 1.0),
        vec4(1.0, 0.15, -0.15, 1.0),
        vec4(1.0, -0.15, -0.15, 1.0)],

    vertexColors: [
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),],
    indices: [
        1, 0, 3,
        3, 2, 1,
        2, 3, 7,
        7, 6, 2,
        3, 0, 4,
        4, 7, 3,
        6, 5, 1,
        1, 2, 6,
        4, 5, 6,
        6, 7, 4,
        5, 4, 0,
        0, 1, 5
    ],
    materialAmbient: vec4(0.7, 0.5, 0.45, 1.0),
    materialDiffuse: vec4(0.9, 0.75, 0.6, 1.0),
    materialSpecular: vec4(0.9, 0.75, 0.6, 1.0),
    materialShininess: 20.0
}
var RightArm = {
    numElements: 36,
    vertices: [
        vec4(-1.0, -0.15, 0.15, 1.0),
        vec4(-1.0, 0.15, 0.15, 1.0),
        vec4(0.0, 0.15, 0.15, 1.0),
        vec4(0.0, -0.15, 0.15, 1.0),
        vec4(-1.0, -0.15, -0.15, 1.0),
        vec4(-1.0, 0.15, -0.15, 1.0),
        vec4(0.0, 0.15, -0.15, 1.0),
        vec4(0.0, -0.15, -0.15, 1.0)],

    vertexColors: [
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),
        vec4(0.9, 0.75, 0.6, 1.0),],
    indices: [
        1, 0, 3,
        3, 2, 1,
        2, 3, 7,
        7, 6, 2,
        3, 0, 4,
        4, 7, 3,
        6, 5, 1,
        1, 2, 6,
        4, 5, 6,
        6, 7, 4,
        5, 4, 0,
        0, 1, 5
    ],
    materialAmbient: vec4(0.7, 0.5, 0.45, 1.0),
    materialDiffuse: vec4(0.9, 0.75, 0.6, 1.0),
    materialSpecular: vec4(0.9, 0.75, 0.6, 1.0),
    materialShininess: 20.0
}
var head;
var body;
var leftarm;
var rightarm;

var rotY = 0;
var rotZ = 0;
var rotAllX = false;
var rotAllY = false;
var rotAllZ = false;
var camX = false;
var camY = false;

var lightPosition = vec4(0, 0, 5, 1.0);
var lightAmbient = vec4(0.8, 0.8, 0.8, 1.0);
var lightDiffuse = vec4(1.0, 1.0, 1.0, 1.0);
var lightSpecular = vec4(1.0, 1.0, 1.0, 1.0);


var modelViewMatrix;
var projectionMatrix;

var eye;
const at = vec3(0.0, 0.0, 0.0);
const up = vec3(0.0, 1.0, 0.0);
var near = 0.3;
var far = 10.0;

var radius = 8.0;
var rtheta = 0.0;

var phi = 0.0;
var dr = 5.0 * Math.PI / 180.0;

var fovy = 45.0;  // Field-of-view in Y direction angle (in degrees)
var aspect;       // Viewport aspect ration

window.onload = function init() {
    canvas = document.getElementById("gl-canvas");

    gl = canvas.getContext('webgl2');
    if (!gl) { alert("WebGL 2.0 isn't available"); }

    head = new Object(Head);
    body = new Object(Body);
    leftarm = new Object(LeftArm);
    rightarm = new Object(RightArm);

    head.Initialize();
    body.Initialize();
    leftarm.Initialize();
    rightarm.Initialize();

    aspect = canvas.width / canvas.height;

    gl.viewport(0, 0, canvas.width, canvas.height);
    gl.clearColor(0.5, 0.5, 0.5, 1.0);

    gl.enable(gl.DEPTH_TEST);

    document.getElementById("slideY").oninput = function () {
        rotY = event.target.value;
        leftarm.Rotate(0, rotY, rotZ);
        rightarm.Rotate(0, -rotY, -rotZ);
    };

    document.getElementById("slideZ").oninput = function () {
        rotZ = event.target.value;
        leftarm.Rotate(0, rotY, rotZ);
        rightarm.Rotate(0, -rotY, -rotZ);
    };
    document.getElementById("rotX").onclick = function () {
        rotAllX = !rotAllX
    }
    document.getElementById("rotY").onclick = function () {
        rotAllY = !rotAllY;
    }
    document.getElementById("rotZ").onclick = function () {
        rotAllZ = !rotAllZ;
    }
    document.getElementById("camX").onclick = function () {
        camX = !camX;
    }
    document.getElementById("camY").onclick = function () {
        camY = !camY;
    }
    document.getElementById("ZoomIn").onclick = function () {
        if (radius > 0)
            radius -= 0.2;
    }
    document.getElementById("ZoomOut").onclick = function () {
        if (radius < 10)
            radius += 0.2;
    }
    document.getElementById("lightX").oninput = function () {
        var val = event.target.value;
        lightPosition[0]=val;
    };
    document.getElementById("lightY").oninput = function () {
        var val = event.target.value;
        lightPosition[1]=val;
    };
    document.getElementById("lightZ").oninput = function () {
        var val = event.target.value;
        lightPosition[2]=val;
    };
    render();

}

function render() {
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
    head.Translate(0, 1, 0);
    leftarm.Translate(0.5, 0, 0);
    rightarm.Translate(-0.5, 0, 0);
    if (rotAllX) {
        head.RotateAll(0.25, 0, 0);
        body.RotateAll(0.25, 0, 0);
        leftarm.RotateAll(0.25, 0, 0);
        rightarm.RotateAll(0.25, 0, 0);
    }
    if (rotAllY) {
        head.RotateAll(0, 0.25, 0);
        body.RotateAll(0, 0.25, 0);
        leftarm.RotateAll(0, 0.25, 0);
        rightarm.RotateAll(0, 0.25, 0);
    }
    if (rotAllZ) {
        head.RotateAll(0, 0, 0.25);
        body.RotateAll(0, 0, 0.25);
        leftarm.RotateAll(0, 0, 0.25);
        rightarm.RotateAll(0, 0, 0.25);
    }
    if (camX)
        rtheta += 0.05;
    if (camY)
        phi += 0.05;
    eye = vec3(radius * Math.sin(rtheta) * Math.cos(phi),
        radius * Math.sin(rtheta) * Math.sin(phi), radius * Math.cos(rtheta));

    modelViewMatrix = lookAt(eye, at, up);
    projectionMatrix = perspective(fovy, aspect, near, far);

    head.Draw();
    body.Draw();
    leftarm.Draw();
    rightarm.Draw();
    requestAnimationFrame(render);
}

class Object {
    constructor(obj) {
        this.obj = obj;
        this.program = initShaders(gl, "vertex-shader", "fragment-shader");
        this.vertices = obj.vertices;
        this.vertexColors = obj.vertexColor;
        this.indices = obj.indices;
        this.numElements = obj.numElements;
        this.theta = [0, 0, 0];
        this.thetaAll = [0, 0, 0];
        this.CTM = mat4(
            1.0, 0.0, 0.0, 0.0,
            0.0, 1.0, 0.0, 0.0,
            0.0, 0.0, 1.0, 0.0,
            0.0, 0.0, 0.0, 1.0);
        this.t = mat4(1.0, 0.0, 0.0, 0,
            0.0, 1.0, 0.0, 0,
            0.0, 0.0, 1.0, 0,
            0.0, 0.0, 0.0, 1.0);

        this.normalArray = [];

        this.Lighting();

    }
    Initialize() {
        this.program = initShaders(gl, "vertex-shader", "fragment-shader");
        this.iBuffer = gl.createBuffer();
        this.cBuffer = gl.createBuffer();
        //this.colorLoc = gl.getAttribLocation(this.program, "aColor");
        this.vBuffer = gl.createBuffer();
        this.positionLoc = gl.getAttribLocation(this.program, "aPosition");
        this.CTMLoc = gl.getUniformLocation(this.program, "CTM");
        this.projLoc = gl.getUniformLocation(this.program, "uProjectionMatrix");
        this.modViewLoc = gl.getUniformLocation(this.program, "uModelViewMatrix");
        this.nBuffer = gl.createBuffer();
        this.normalLoc = gl.getAttribLocation(this.program, "aNormal");

    }
    Translate(x, y, z) {
        this.t = mat4(1.0, 0.0, 0.0, x,
            0.0, 1.0, 0.0, y,
            0.0, 0.0, 1.0, z,
            0.0, 0.0, 0.0, 1.0);
    }
    Rotate(x, y, z) {
        this.theta[0] = x;
        this.theta[1] = y;
        this.theta[2] = z;
    }
    RotateAll(x, y, z) {
        this.thetaAll[0] += x;
        this.thetaAll[1] += y;
        this.thetaAll[2] += z;
    }
    Draw() {

        gl.useProgram(this.program);

        gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, this.iBuffer);
        gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint8Array(this.indices), gl.STATIC_DRAW);

        // gl.bindBuffer(gl.ARRAY_BUFFER, this.cBuffer);
        // gl.bufferData(gl.ARRAY_BUFFER, flatten(this.vertexColors), gl.STATIC_DRAW);

        // gl.vertexAttribPointer(this.colorLoc, 4, gl.FLOAT, false, 0, 0);
        // gl.enableVertexAttribArray(this.colorLoc);




        gl.uniform4fv(gl.getUniformLocation(this.program, "uAmbientProduct"), flatten(this.ambientProduct));
        gl.uniform4fv(gl.getUniformLocation(this.program, "uDiffuseProduct"), flatten(this.diffuseProduct));
        gl.uniform4fv(gl.getUniformLocation(this.program, "uSpecularProduct"), flatten(this.specularProduct));
        gl.uniform4fv(gl.getUniformLocation(this.program, "uLightPosition"), flatten(lightPosition));
        gl.uniform1f(gl.getUniformLocation(this.program, "uShininess"), this.materialShininess)

        gl.bindBuffer(gl.ARRAY_BUFFER, this.vBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, flatten(this.vertices), gl.STATIC_DRAW);

        gl.vertexAttribPointer(this.positionLoc, 4, gl.FLOAT, false, 0, 0);
        gl.enableVertexAttribArray(this.positionLoc);

        var angleX = this.theta[0] * Math.PI / 180.0;
        var angleY = this.theta[1] * Math.PI / 180.0;
        var angleZ = this.theta[2] * Math.PI / 180.0;
        var cx = Math.cos(angleX);
        var sx = Math.sin(angleX);
        var cy = Math.cos(angleY);
        var sy = Math.sin(angleY);
        var cz = Math.cos(angleZ);
        var sz = Math.sin(angleZ);

        var rx = mat4(1.0, 0.0, 0.0, 0.0,
            0.0, cx, sx, 0.0,
            0.0, -sx, cx, 0.0,
            0.0, 0.0, 0.0, 1.0);

        var ry = mat4(cy, 0.0, -sy, 0.0,
            0.0, 1.0, 0.0, 0.0,
            sy, 0.0, cy, 0.0,
            0.0, 0.0, 0.0, 1.0);

        var rz = mat4(cz, sz, 0.0, 0.0,
            -sz, cz, 0.0, 0.0,
            0.0, 0.0, 1.0, 0.0,
            0.0, 0.0, 0.0, 1.0);
        var sc = 0.75;
        var scale = mat4(sc, 0.0, 0.0, 0.0,
            0.0, sc, 0.0, 0.0,
            0.0, 0.0, sc, 0.0,
            0.0, 0.0, 0.0, 1.0);

        this.CTM = mult(scale, mult(this.t, (mult(rz, mult(ry, rx)))));
        //this.CTM = mult(this.t, (mult(rz, mult(ry, rx))));
        angleX = this.thetaAll[0] * Math.PI / 180.0;
        angleY = this.thetaAll[1] * Math.PI / 180.0;
        angleZ = this.thetaAll[2] * Math.PI / 180.0;
        cx = Math.cos(angleX);
        sx = Math.sin(angleX);
        cy = Math.cos(angleY);
        sy = Math.sin(angleY);
        cz = Math.cos(angleZ);
        sz = Math.sin(angleZ);

        var rx2 = mat4(1.0, 0.0, 0.0, 0.0,
            0.0, cx, sx, 0.0,
            0.0, -sx, cx, 0.0,
            0.0, 0.0, 0.0, 1.0);

        var ry2 = mat4(cy, 0.0, -sy, 0.0,
            0.0, 1.0, 0.0, 0.0,
            sy, 0.0, cy, 0.0,
            0.0, 0.0, 0.0, 1.0);

        var rz2 = mat4(cz, sz, 0.0, 0.0,
            -sz, cz, 0.0, 0.0,
            0.0, 0.0, 1.0, 0.0,
            0.0, 0.0, 0.0, 1.0);
        this.CTM = mult(rz2, mult(ry2, mult(rx2, this.CTM)));

        gl.vertexAttribPointer(this.normalLoc, 3, gl.FLOAT, false, 0, 0);
        gl.enableVertexAttribArray(this.normalLoc);

        gl.bindBuffer(gl.ARRAY_BUFFER, this.nBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, flatten(this.normalArray), gl.STATIC_DRAW);
        gl.uniformMatrix4fv(gl.getUniformLocation(this.program, "normalTransformation"), false, flatten(this.CTM));

        this.CTM = mult(projectionMatrix, mult(modelViewMatrix, this.CTM));
        gl.uniformMatrix4fv(this.CTMLoc, false, flatten(this.CTM));
        gl.uniformMatrix4fv(this.projLoc, false, flatten(modelViewMatrix));
        gl.uniformMatrix4fv(this.modViewLoc, false, flatten(projectionMatrix));

        gl.drawElements(gl.TRIANGLES, this.numElements, gl.UNSIGNED_BYTE, 0);
    }

    Lighting() {
        this.ambientProduct = mult(lightAmbient, this.obj.materialAmbient);
        this.diffuseProduct = mult(lightDiffuse, this.obj.materialDiffuse);
        this.specularProduct = mult(lightSpecular, this.obj.materialSpecular);
        this.materialShininess = this.obj.materialShininess;
        for (let i = 0; i < this.obj.indices.length / 3; i += 2) {
            var t1 = subtract(this.obj.vertices[this.obj.indices[3 * i + 1]], this.obj.vertices[this.obj.indices[3 * i]]);

            var t2 = subtract(this.obj.vertices[this.obj.indices[3 * i + 2]], this.obj.vertices[this.obj.indices[3 * i + 1]]);
            //console.log(t1);
            var normal = cross(t1, t2);
            //console.log(normal);
            this.normalArray.push(normal);
            this.normalArray.push(normal);
            this.normalArray.push(normal);
            this.normalArray.push(normal);
            this.normalArray.push(normal);
            this.normalArray.push(normal);
        }
    }
}