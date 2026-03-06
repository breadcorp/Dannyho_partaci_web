// Import knihoven
const express = require('express');
const session = require('express-session');
const passport = require('passport');
const LocalStrategy = require('passport-local').Strategy;
const sqlite3 = require('sqlite3').verbose();
const path = require('path');
const bcrypt = require('bcrypt');

const app = express();
const db = new sqlite3.Database('./user_auth.db');

// Middleware pro zpracování formulářových dat
app.use(express.urlencoded({ extended: true }));

// Nastavení EJS jako templating engine
app.set('view engine', 'ejs');
app.use(express.static(path.join(__dirname, '../')));


// Inicializace relací a Passportu
app.use(session({
  secret: 'tajnyKlic',
  resave: false,
  saveUninitialized: true,
}));
app.use(passport.initialize());
app.use(passport.session());

// Konfigurace Local Strategy pro přihlášení
passport.use(
  new LocalStrategy((username, password, done) => {
    db.get('SELECT * FROM users WHERE username = ?', [username], (err, row) => {
      if (err) {
        return done(err);
      }
      if (!row) {
        return done(null, false, { message: 'Nesprávné uživatelské jméno.' });
      }
      bcrypt.compare(password, row.password, (err, res) => {
        if (res) {
          return done(null, row);
        } else {
          return done(null, false, { message: 'Nesprávné heslo.' });
        }
      });
    });
  })
);

passport.serializeUser((user, done) => {
  done(null, user.id);
});

passport.deserializeUser((id, done) => {
  db.get('SELECT * FROM users WHERE id = ?', [id], (err, row) => {
    if (!row) {
      return done(err);
    }
    done(null, row);
  });
});

// Hlavní stránka s formulářem pro přihlášení
app.get('/', (req, res) => {
  res.render('login');
});

// Zpracování přihlášení
app.post(
  '/login',
  passport.authenticate('local', {
    successRedirect: '/dashboard',
    failureRedirect: '/',
    failureFlash: false,
  })
);

// Dashboard - pouze pro přihlášené uživatele
app.get('/dashboard', isLoggedIn, (req, res) => {
  const userInfo = req.user;
  db.all('SELECT info FROM data', [], (err, rows) => {
    if (err) {
      return res.status(500).send('Chyba při načítání dat');
    }
    const data = rows.map(row => row.info);
    res.render('dashboard', { user: userInfo, data });
  });
});

// Odhlášení
app.get('/logout', (req, res) => {
  req.logout((err) => {
    if (err) {
      return next(err);
    }
    res.redirect('/');
  });
});

// Zajištění, že uživatel je přihlášen
function isLoggedIn(req, res, next) {
  if (req.isAuthenticated()) {
    return next();
  }
  res.redirect('/');
}

// Spuštění serveru
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server běží na portu ${PORT}`);
});