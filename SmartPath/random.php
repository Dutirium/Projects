<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Tension Effect - Silver & Grey</title>
    <style>
        /* General Page Styling */
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #0a0f1a;
            height: 100vh;
            cursor: crosshair;
        }

        /* Container for Water Effect */
        .water-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        /* Water Ripple Effect */
        .ripple {
            position: absolute;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, rgba(192, 192, 192, 0.6), rgba(128, 128, 128, 0.3), transparent);
            border-radius: 50%;
            pointer-events: none;
            transform: scale(0);
            animation: rippleEffect 1.2s ease-out forwards;
            box-shadow: 0 0 8px 2px rgba(192, 192, 192, 0.5);
        }

        @keyframes rippleEffect {
            0% {
                transform: scale(0);
                opacity: 0.9;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: scale(10);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="water-container" id="waterContainer"></div>

    <script>
        const waterContainer = document.getElementById('waterContainer');

        // Create ripple effect on mouse move
        waterContainer.addEventListener('pointermove', (event) => {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            
            // Position the ripple relative to mouse movement
            ripple.style.left = `${event.clientX}px`;
            ripple.style.top = `${event.clientY}px`;

            waterContainer.appendChild(ripple);

            // Remove the ripple after animation completes
            ripple.addEventListener('animationend', () => {
                ripple.remove();
            });
        });
    </script>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Click Ripple Effect - Silver & Grey</title>
    <style>
        /* General Page Styling */
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #0a0f1a;
            height: 100vh;
            cursor: pointer;
        }

        /* Container for Water Effect */
        .water-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        /* Water Ripple Effect */
        .ripple {
            position: absolute;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, rgba(192, 192, 192, 0.6), rgba(128, 128, 128, 0.3), transparent);
            border-radius: 50%;
            pointer-events: none;
            transform: scale(0);
            animation: rippleEffect 1.2s ease-out forwards;
            box-shadow: 0 0 8px 2px rgba(192, 192, 192, 0.5);
        }

        @keyframes rippleEffect {
            0% {
                transform: scale(0);
                opacity: 0.9;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: scale(15);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="water-container" id="waterContainer"></div>

    <script>
        const waterContainer = document.getElementById('waterContainer');

        // Create ripple effect on click
        waterContainer.addEventListener('click', (event) => {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            
            // Position the ripple relative to mouse click
            ripple.style.left = `${event.clientX - 10}px`;
            ripple.style.top = `${event.clientY - 10}px`;

            waterContainer.appendChild(ripple);

            // Remove the ripple after animation completes
            ripple.addEventListener('animationend', () => {
                ripple.remove();
            });
        });
    </script>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Ripple Effect in Three.js</title>
    <style>
        body { margin: 0; overflow: hidden; }
        canvas { display: block; }
    </style>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        // Scene Setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        // Create a plane geometry (water surface)
        const geometry = new THREE.PlaneGeometry(20, 20, 100, 100);
        const material = new THREE.MeshBasicMaterial({
            color: 0xaaaaaa,
            wireframe: true,
            side: THREE.DoubleSide
        });

        const plane = new THREE.Mesh(geometry, material);
        plane.rotation.x = -Math.PI / 2; // Rotate the plane so it faces the camera
        scene.add(plane);

        // Add light to the scene
        const light = new THREE.PointLight(0xffffff, 1, 100);
        light.position.set(5, 5, 5);
        scene.add(light);

        // Camera Position
        camera.position.z = 20;

        // Store the positions of the vertices for updating
        const vertices = geometry.attributes.position.array;

        // Ripple effect on mouse move
        document.addEventListener('mousemove', (event) => {
            const mouseX = (event.clientX / window.innerWidth) * 2 - 1;
            const mouseY = -(event.clientY / window.innerHeight) * 2 + 1;

            const x = mouseX * 10;  // Map mouse X to plane space
            const y = mouseY * 10;  // Map mouse Y to plane space

            createRipple(x, y);
        });

        // Function to create a ripple at the mouse position
        function createRipple(x, y) {
            const amplitude = 0.5;  // Strength of the ripple
            const frequency = 0.1;  // How wide the ripple spreads

            // Iterate over the vertices of the geometry
            for (let i = 0; i < vertices.length; i += 3) {
                const vertex = new THREE.Vector3(vertices[i], vertices[i + 1], vertices[i + 2]);

                // Calculate distance from mouse position
                const distance = vertex.distanceTo(new THREE.Vector3(x, 0, y));
                const offset = amplitude * Math.sin(frequency * distance); // Apply sine wave to create ripple

                // Apply the ripple offset to the Z position of the vertex
                vertices[i + 2] = offset;
            }

            geometry.attributes.position.needsUpdate = true; // Update the geometry
        }

        // Resize window handling
        window.addEventListener('resize', () => {
            renderer.setSize(window.innerWidth, window.innerHeight);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
        });

        // Animation Loop
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }

        animate();
    </script>
</body>
</html>

