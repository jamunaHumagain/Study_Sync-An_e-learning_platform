<!DOCTYPE html>
<html>

<head>
    <title>Google Sign-In with Firebase</title>
    <script src="https://www.gstatic.com/firebasejs/9.20.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.20.0/firebase-auth-compat.js"></script>
</head>

<body>
    <button id="google-signin">Sign in with Google</button>

    <script type="module">
        // Import Firebase modules
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.20.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/9.20.0/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyBzUd35f_AG_3HaGxX22YnM8B5a8cEuYbE",
            authDomain: "jamuna-e8f7c.firebaseapp.com",
            projectId: "jamuna-e8f7c",
            storageBucket: "jamuna-e8f7c.appspot.com",
            messagingSenderId: "316930929041",
            appId: "1:316930929041:web:1cf1129b1fd16e53942a30"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        // Handle Google Sign-In
        document.getElementById('google-signin').addEventListener('click', () => {
            signInWithPopup(auth, provider)
                .then((result) => {
                    // User signed in successfully
                    const user = result.user;
                    const googleId = user.uid;
                    const name = user.displayName;
                    const email = user.email;
                    const picture = user.photoURL;

                    console.log('Google ID:', googleId);
                    console.log('Name:', name);
                    console.log('Email:', email);
                    console.log('Picture:', picture);
                    alert(`Welcome ${name}`);

                    // Handle user data (send to backend or manage in client-side)
                    fetch('/your-backend-endpoint', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ googleId, name, email, picture })
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });

                }).catch((error) => {
                    // Handle Errors here.
                    console.error('Error during sign-in:', error);
                });
        });
    </script>
</body>

</html>