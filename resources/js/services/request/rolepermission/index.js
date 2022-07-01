import axios from "axios";


export const addPermissionInRole = async (content) => {
    try {
        await axios.post(`/roles/${content.role}/routes`,content)
        return true;
    } catch (error) {
        return false;
    }
}