import Service from './Service';
import QueryString from  'query-string';

export default class EventService {
    constructor() {
        this.service = Service('event');
    }
    
    async getList(page, filter) {
        try {
            const params = QueryString.stringify(filter);
            const events = await this.service.get(`/${page}?${params}`);
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