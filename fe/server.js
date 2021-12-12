const express = require('express')
const serveStatic = require('serve-static')
const path = require('path')

const app = express()

app.use('/', serveStatic(path.join(__dirname, '/dist')))
app.use('/register/admin', serveStatic(path.join(__dirname, '/dist')))
app.use('/register/student', serveStatic(path.join(__dirname, '/dist')))
app.use('/about', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/home', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/colleges', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/courses', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/sections', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/organizations', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/announcements', serveStatic(path.join(__dirname, '/dist')))
app.use('/dashboard/students', serveStatic(path.join(__dirname, '/dist')))

app.use('/user', serveStatic(path.join(__dirname, '/dist')))
app.use('/user/home', serveStatic(path.join(__dirname, '/dist')))
app.use('/user/members', serveStatic(path.join(__dirname, '/dist')))
app.use('/user/payments', serveStatic(path.join(__dirname, '/dist')))
app.use('/user/announcements', serveStatic(path.join(__dirname, '/dist')))

const port = process.env.PORT || 8080
app.listen(port)