var scene;
var camera;
var light;
var renderer;
var earthObject;
var controls;

var clock = new THREE.Clock();
var rotationSpeed = 0.02;

var WIDTH = window.innerWidth - 30;
var HEIGHT = window.innerHeight - 30;

var angle = 45;
var aspect = WIDTH / HEIGHT;
var near = 0.1;
var far = 10000;

var container = document.createElement('div');
document.body.appendChild(container);

//cam
camera = new THREE.PerspectiveCamera(angle, aspect, near, far);
camera.position.set(680, -17, 394);

//scene
scene = new THREE.Scene();
camera.lookAt(scene.position);

//light
light = new THREE.SpotLight(0xFFFFFF, 1, 0, Math.PI / 2, 1);
light.position.set(4000, 4000, 1500);
light.target.position.set (1000, 3800, 1000);

var lightAll = new THREE.AmbientLight( 0x222222 );

scene.add(light);
scene.add(lightAll);

var earthGeo = new THREE.SphereGeometry (200, 400, 400);
var earthMat = new THREE.MeshPhongMaterial();
var earthMesh = new THREE.Mesh(earthGeo, earthMat);

earthMesh.position.set(-100, 0, 0);
earthMesh.rotation.y=5;
scene.add(earthMesh);

// diffuse map
earthMat.map = THREE.ImageUtils.loadTexture('images/earth.jpg');

// bump map
earthMat.bumpMap = THREE.ImageUtils.loadTexture('images/high-bump.jpg');
earthMat.bumpScale = 5;

camera.lookAt( earthMesh.position );

//renderer
var renderer = new THREE.WebGLRenderer({antialiasing : true});
renderer.setSize(WIDTH, HEIGHT);

container.appendChild(renderer.domElement);

//controls
// controls = new THREE.OrbitControls( camera, renderer.domElement );

function animate() {
  requestAnimationFrame(animate);
  render();
}

function render() {
  var delta = clock.getDelta();

  earthMesh.rotation.y += rotationSpeed * delta;
  renderer.render(scene, camera);
}

animate();
