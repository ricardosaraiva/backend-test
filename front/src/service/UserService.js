import Service from './Service';

export default class UserService {
    constructor(name) {
        this.name = name;
    }

    static getUser() {

        return null;
        
        return new UserService(
            'Ricardo Saraiva'
        );
    }

    static logout() {

    }
}