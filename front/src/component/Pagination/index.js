import React, { Component } from 'react';

import P from "react-js-pagination";

import { Container } from './styles';

export default class Pagination extends Component {

  render() {
    return <Container>
        <P
          activePage={this.props.active}
          itemsCountPerPage={this.props.itemPerPage}
          totalItemsCount={this.props.totalItem}
          pageRangeDisplayed={5}
          onChange={this.props.handle}
        />        
    </Container>;
  }
}
