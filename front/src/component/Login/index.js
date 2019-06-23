import React, { Component } from 'react';
import Modal, { Title, Body } from '../Modal';
import Form, { Input, ButtonSubmit } from '../Form';
import Row from '../Row';

export default class Login extends Component {
  render() {
    return (
        <Modal 
          open={this.props.open} 
          handlerClose={() => {this.props.handlerClose()}}
          closeButton
          >

          <Title>Login</Title>
          
          <Body>
            <Form>
              <Row>
                <Input label="User" id="user" />
                <Input label="Password" id="password" />
              </Row>

              <div className="text-center">
                  <ButtonSubmit>Logar</ButtonSubmit>          
              </div>
            
            </Form>
          </Body>
          
        </Modal>
    );
  }
}
