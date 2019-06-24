import React, { Component, Fragment } from 'react';

import {Container, Title} from '../../../component/Page';
import EventService from '../../../service/EventService';

export default class Detail extends Component {
    state = {
        notFound: false,
        event: {} 
    };

    async componentDidMount() {
        const eventService = new EventService()
        const event = await eventService.getDetail(this.props.match.params.id); 
        this.setState({event: event, notFound: event == null});
        
    }

    renderNotFount() {
        return (
            <Fragment>Evento não encontrado</Fragment>
        );
    }

    renderDetail() {
        return (
            <Fragment>
                <Title>
                    {this.state.event.name}
                    {this.state.event.cancel && <span> (Cancel) </span>} 
                </Title>

                <p>
                    <b>Date: </b> {this.state.event.date}
                </p>

                <p>
                    <b>Description: </b> {this.state.event.description}
                </p>

                <p>
                    <b>City: </b> {this.state.event.city}
                </p>

                <p>
                    <b>State: </b> {this.state.event.state}
                </p>

                <p>
                    <b>Address: </b> {this.state.event.address}
                </p>

            </Fragment>
        );
    }

    render() {
        return <Container>
            {this.state.notFound && this.renderNotFount()}
            {!this.state.notFound && this.renderDetail()}
        </Container>;
    }
}
