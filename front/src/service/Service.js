import axios from 'axios';

export default (url) => {

    const headers = {

    };

    return axios.create({
        baseURL: `http://localhost:8082/${url}`,
        headers: headers
    })
}
