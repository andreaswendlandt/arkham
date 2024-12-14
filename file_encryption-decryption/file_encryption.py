#!/usr/bin/env python3
# how to use:
#   encrypting:
#     /file_encryption.py foo.txt --encrypt | -e
#     /file_encryption.py foo.txt --encrypt | -e -s | --salt-size 32
#   decrypting:
#     /file_encryption.py foo.txt --decrypt | -d

import cryptography
from cryptography.fernet import Fernet
from cryptography.hazmat.primitives.kdf.scrypt import Scrypt
import secrets
import base64
import getpass
from pathlib import Path

def generate_salt(size=16):
    return secrets.token_bytes(size)

def derive_key(salt, password):
    kdf = Scrypt(salt=salt, length=32, n=2**14, r=8, p=1)
    return kdf.derive(password.encode())

def load_salt():
    return open("salt.salt", "rb").read()

def generate_key(password, salt_size=16, load_existing_salt=False, save_salt=True):
    if load_existing_salt:
        salt = load_salt()
    elif save_salt:
        salt = generate_salt(salt_size)
        with open("salt.salt", "wb") as salt_file:
            salt_file.write(salt)
    derived_key = derive_key(salt, password)
    return base64.urlsafe_b64encode(derived_key)

def encrypt(filename, key):
    f = Fernet(key)
    with open(filename, "rb") as file:
        file_data = file.read()
    encrypted_data = f.encrypt(file_data)
    with open(filename, "wb") as file:
        file.write(encrypted_data)

def decrypt(filename, key):
    f = Fernet(key)
    with open(filename, "rb") as file:
        encrypted_data = file.read()
    try:
        decrypted_data = f.decrypt(encrypted_data)
    except cryptography.fernet.InvalidToken:
        print("invalid token, most likely the password is incorrect")
        return
    with open(filename, "wb") as file:
        file.write(decrypted_data)
    print("file decrypted successfully")

if __name__ == "__main__":
    import argparse
    parser = argparse.ArgumentParser(description="file encryption/decryption script with a password")
    parser.add_argument("file", help="file to encrypt/decrypt")
    parser.add_argument("-s", "--salt-size", help="if this is set, a new salt with the passed size is generated", type=int)
    parser.add_argument("-e", "--encrypt", action="store_true", help="to encrypt the file, only -e or --encrypt can be specified")
    parser.add_argument("-d", "--decrypt", action="store_true", help="to decrypt the file, only -d or --decrypt can be specified")

    args = parser.parse_args()
    file = args.file
    salty_salt = Path('./salt.salt')
    if args.encrypt:
        password = getpass.getpass("enter the password for encryption: ")
    elif args.decrypt:
        password = getpass.getpass("enter the password you used for encryption: ")

    if args.salt_size:
        key = generate_key(password, salt_size=args.salt_size, save_salt=True)
    else:
        if salty_salt.exists():
            key = generate_key(password, load_existing_salt=True)
        else:
            key = generate_key(password, load_existing_salt=False)

    encrypt_ = args.encrypt
    decrypt_ = args.decrypt

    if encrypt_ and decrypt_:
        raise TypeError("please specify whether you want to encrypt or decrypt the file.")
    elif encrypt_:
        encrypt(file, key)
    elif decrypt_:
        decrypt(file, key)
    else:
        raise TypeError("please specify whether you want to encrypt or decrypt the file.")
