import React, { Component, Fragment } from 'react';
import {Container, Title} from '../../../component/Page';
import Table , {THead, TBody, Tr, Th, Td, TButtonIcon} from '../../../component/Table';
import Form , {Input, ButtonSubmit} from '../../../component/Form';
import Row from '../../../component/Row';
import EventService from '../../../service/EventService';


export default class List extends Component {
  state = {
    events: {
      page: 0,
      data: []
    }
  };

  constructor(props) {
    super(props);

    this.serviceEvent = new EventService();
  }

  async getEvents() {
    const events = await this.serviceEvent.getList();
    this.setState({events: events});
  }

  componentDidMount() {
    this.getEvents();
  }

  render() {
    return <Container>
        <Title>Events</Title>

        <Form>
          <Row>
            <Input label="place" label="Place" />
            <Input label="date" label="Date" />
          </Row>
          <ButtonSubmit>
            Filtrar
          </ButtonSubmit>
        </Form>

        <Table>
          <THead>
            <Tr>
              <Th>Name</Th>
              <Th>Date</Th>
              <Th></Th>
            </Tr>
          </THead>
          <TBody>
            {this.state.events.data.map(event => (
              <Tr key={event.id}>
                <Td>{event.name}</Td>
                <Td>{event.date}</Td>
                <Td className="text-center">
                  <TButtonIcon>
                    <i className="fas fa-search" />
                  </TButtonIcon>
                </Td>
              </Tr>
            ))}
          </TBody>
        </Table>
    </Container>;
  }
}
