import React, { Component } from 'react';
import {Container, Title} from '../../../component/Page';
import Table , {THead, TBody, Tr, Th, Td, TLinkIcon} from '../../../component/Table';
import Form , {Input, ButtonSubmit, InputMask} from '../../../component/Form';
import Row from '../../../component/Row';
import EventService from '../../../service/EventService';
import Pagination from '../../../component/Pagination';


export default class List extends Component {
  state = {
    filter: {
      dateStart: '',
      dateEnd: '',
      place: ''
    },
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

  async getEvents(page, filter) {
    const events = await this.serviceEvent.getList(page, filter);
    const pageData = {
      active: page, 
      itemsPerPage: events.itemsPerPage,
      totalItem: events.items
    };

    this.setState({events: events.data, page : pageData});
  }

  componentDidMount() {
    this.getEvents(1, {});
  }

  handlePage(pageNumber) {
    this.getEvents(pageNumber, this.getEvents.filter);
  }

  handleFilter(e) {
    const filter = Object.assign({}, this.state.filter);
    filter[e.target.name] = e.target.value;

    this.setState({filter: filter});
  }

  filter(e) {
    e.preventDefault();
    this.getEvents(1, this.state.filter);
  }

  render() {
    return <Container>
        <Title>Events</Title>

        <Form onSubmit={e => this.filter(e)}>
          <Row>
            <Input 
              id="place" 
              label="Place" 
              input={{onChange:  e => this.handleFilter(e)}}
              container={{className:'col-md-4'}}/>
              
            <InputMask
              id="dateStart" 
              label="Date"  
              mask="9999-99-99"
              input={{onChange:  e => this.handleFilter(e)}}
              container={{className:'col-md-4'}}/>

            <InputMask
              id="dateEnd" 
              label="Date"  
              mask="9999-99-99"
              input={{onChange:  e => this.handleFilter(e)}}
              container={{className:'col-md-4'}}/>
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
