import React, { Component, Fragment } from 'react';
import {Container, Title} from '../../../component/Page';
import Table , {THead, TBody, Tr, Th, Td, TLinkIcon} from '../../../component/Table';
import Form , {Input, ButtonSubmit} from '../../../component/Form';
import Row from '../../../component/Row';
import EventService from '../../../service/EventService';
import Pagination from '../../../component/Pagination';


export default class List extends Component {
  state = {
    page: {
      active: 1,
      itemsPerPage: 0,
      totalItem: 0      
    },
    events: []
  };

  constructor(props) {
    super(props);
    this.serviceEvent = new EventService();
  }

  async getEvents(page) {
    const events = await this.serviceEvent.getList(page);
    const pageData = {
      active: page, 
      itemsPerPage: events.itemsPerPage,
      totalItem: events.items
    };

    this.setState({events: events.data, page : pageData});
  }

  componentDidMount() {
    this.getEvents(1);
  }

  handlePage(pageNumber) {
    this.getEvents(pageNumber);
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
            {this.state.events.map(event => (
              <Tr key={event.id}>
                <Td>{event.name}</Td>
                <Td>{event.date}</Td>
                <Td className="text-center">
                  <TLinkIcon to={`event/${event.id}/detail`} >
                    <i className="fas fa-search" />
                  </TLinkIcon>
                </Td>
              </Tr>
            ))}
          </TBody>
        </Table>

        <Pagination 
          active={this.state.page.active} 
          itemsPerPage={this.state.page.itemsPerPage}
          totalItem={this.state.page.totalItem}
          handle={pageNunber => this.handlePage(pageNunber)}
        />

    </Container>;
  }
}
