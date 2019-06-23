import React, { Component } from 'react';

import {
  Container,
  BrandContainer,
  BrandIcon,
  BrandText,
  ContainerButton,
  Button
} from './styles';
import Modal, {Title, Body} from '../../component/Modal';
import Row from '../../component/Row';
import Form, {Input} from '../../component/Form';
import Login from '../../component/Login';
import Register from '../../component/Register';

export default class NavDefault extends Component {
  state = {
    loginModal: false,
    registerModal: true
  };

  render() {
    return (
      <Container>
        <BrandContainer>
          <BrandIcon className="fas fa-user"/>
          <BrandText>Event Network</BrandText>
        </BrandContainer>

        <ContainerButton>
          <Button onClick={() => this.setState({loginModal: true})}>Login</Button>
          <Button onClick={() => this.setState({registerModal: true})}>Register</Button>
        </ContainerButton>

        <Login 
          open={this.state.loginModal} 
          handlerClose={() => this.setState({loginModal: false})} />

        <Register 
          open={this.state.registerModal} 
          handlerClose={() => this.setState({registerModal: false})} />


      </Container>
    );
  }
}
