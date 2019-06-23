import React, { Component } from 'react';
import Modal, { Title, Body } from '../Modal';
import Row from '../Row';
import Form, {Input, InputFile, ButtonSubmit} from '../Form';

export default class Register extends Component {
  render() {
    return (
        <Modal 
        open={this.props.open} 
        handlerClose={() => {this.props.handlerClose()}}
        closeButton
        >

            <Title>Register</Title>
            
            <Body>
            <Form>
                <Row>
                    <Input label="User" id="user" />
                    <Input label="Email" id="email" />
                </Row>

                <Row>
                    <Input label="City" id="city" />
                    <Input label="State" id="state" />
                </Row>

                <Row>
                    <Input label="Bio" id="bio" />
                    <Input label="Password" id="password" />
                </Row>


                <Row>
                    <InputFile label="Picture" name="picture"/>
                </Row>

                <div className="text-center">
                    <ButtonSubmit>Gravar</ButtonSubmit>          
                </div>
            
            </Form>
            </Body>
            
        </Modal>
    );
  }
}
