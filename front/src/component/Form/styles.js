import styled from 'styled-components';

const Container = styled.div``;

const Label = styled.label`
    font-weight: bold;
`;

const Input = styled.input``;

const ButtonSubmit = styled.button`
    margin: 10px auto;
`;

Container.defaultProps = {
    className: 'col-md-6 col-lg-6'
};

Input.defaultProps = {
    className: 'form-control'
};

ButtonSubmit.defaultProps = {
    className: 'btn btn-primary'
}

export {
    Container,
    Label,
    Input,
    ButtonSubmit
}