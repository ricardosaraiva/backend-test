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
            console.error(e);   
        }
    }

    async getDetail(id) {
        try {
            const events = await this.service.get(`/${id}/detail`);
            return events.data;
        } catch(e) {
            alert(e);
            console.error(e);   
        }
    }
}