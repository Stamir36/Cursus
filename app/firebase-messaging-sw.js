importScripts('https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js');

const firebaseConfig = {
  apiKey: "AIzaSyCoj9xpaHuES994IWK4s33FMQq5G1vzK7Y",
  authDomain: "unesell.firebaseapp.com",
  projectId: "unesell",
  storageBucket: "unesell.appspot.com",
  messagingSenderId: "786154684558",
  appId: "1:786154684558:web:7f1b8c9ff0b420d13d89df",
  measurementId: "G-R9G9CJ76NX"
};

// Инициализация Firebase
firebase.initializeApp(firebaseConfig);

// Получение экземпляра Firebase Messaging
const messaging = firebase.messaging();

// Обработка входящих уведомлений
messaging.onBackgroundMessage((payload) => {
  console.log('Получено входящее уведомление:', payload);
});
