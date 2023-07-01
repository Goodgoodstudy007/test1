var SEPARATION = 200,
	AMOUNTX = 70,
	AMOUNTY = 70;
var container;
var camera, scene, renderer;
var particles, particle, count = 0;

var mouseX = -300,
	mouseY = -1080;
var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 1;
init();
animate();
function init() {
	container = document.createElement( 'div' );
	container.id='canvas_box'; 
	document.getElementById("slide_0").appendChild( container );

	camera = new THREE.PerspectiveCamera(120, window.innerWidth / window.innerHeight, 1, 100000);
	camera.position.z = 200; 
	scene = new THREE.Scene(); 
	particles = new Array();

	var PI2 = Math.PI * 2;
	var material = new THREE.ParticleCanvasMaterial({ 
		color: 0x44ace3,
		program: function(context) { 
			context.beginPath();
			context.arc(0, 0, .8, 0, PI2, true);
			context.fill(); 
		} 
	});

	var i = 0; 
	for (var ix = 0; ix < AMOUNTX; ix++) { 
		for (var iy = 0; iy < AMOUNTY; iy++) { 
			particle = particles[i++] = new THREE.Particle(material);
			particle.position.x = ix * SEPARATION - ((AMOUNTX * SEPARATION) / 2);
			particle.position.z = iy * SEPARATION - ((AMOUNTY * SEPARATION) / 2);
			scene.add(particle); 
		} 
	}

	renderer = new THREE.CanvasRenderer();
	renderer.setSize(window.innerWidth, window.innerHeight);
	container.appendChild(renderer.domElement);

	document.addEventListener('mousemove', onDocumentMouseMove, false);
	//document.addEventListener('touchstart', onDocumentTouchStart, false);
	//document.addEventListener('touchmove', onDocumentTouchMove, false);
	// 
	window.addEventListener('resize', onWindowResize, false);
}
function onWindowResize() { 
	windowHalfX = window.innerWidth / 2;
	windowHalfY = window.innerHeight / 1; 
	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix(); 
	renderer.setSize(window.innerWidth, window.innerHeight);

}
//
function onDocumentMouseMove(event) { 
	mouseX = event.clientX - windowHalfX;
	mouseY = event.clientY - windowHalfY; 
}

function onDocumentTouchStart(event) { 
	if (event.touches.length === 1) { 
		event.preventDefault(); 
		mouseX = event.touches[0].pageX - windowHalfX;
		mouseY = event.touches[0].pageY - windowHalfY; 
	} 
}

function onDocumentTouchMove(event) { 
	if (event.touches.length === 1) { 
		event.preventDefault(); 
		mouseX = event.touches[0].pageX - windowHalfX;
		mouseY = event.touches[0].pageY - windowHalfY; 
	} 
}
//
function animate() { 
	requestAnimationFrame(animate); 
	render();  
}

function render() { 
	camera.position.x += (mouseX - camera.position.x) * .05;
	camera.position.y += (-mouseY - camera.position.y) * .05;
	camera.lookAt(scene.position);

	var i = 0; 
	for (var ix = 0; ix < AMOUNTX; ix++) { 
		for (var iy = 0; iy < AMOUNTY; iy++) { 
			particle = particles[i++];
			particle.position.y = (Math.sin((ix + count) * 0.1) * 50) + (Math.sin((iy + count) * 0.2) * 50);
			particle.scale.x = particle.scale.y = (Math.sin((ix + count) * 0.3) + 1) * 2 + (Math.sin((iy + count) * 0.5) + 1) * 2;
		}
	}
	renderer.render(scene, camera);
	count += 0.1;
}