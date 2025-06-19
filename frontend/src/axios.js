import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000/api', // Change this if your Laravel app runs elsewhere
  withCredentials: true, // If using cookies
});

export default instance;
