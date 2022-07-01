import axios from "axios";


export const addRouteInDb = async (permission) => {
    const response = await axios.post(`/routes`,{permission:permission.item})
    console.log('response: 1111', response);
    // return response.data
}