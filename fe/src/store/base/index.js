import axios from 'axios';

const API = axios.create({
    // baseURL: 'http://127.0.0.1:8000/api',
    baseURL: 'http://www.be.evsu-organization-system.com/api',
});

export default API;