import Service from './Service';

export default class EventService {
    constructor() {
        this.service = Service('event');
    }
    
    async getList() {
        try {
            const events = await this.service.get('');
            return events.data;
        } catch(e) {
            alert(e);
            console.log(e);   
        }
    }
}